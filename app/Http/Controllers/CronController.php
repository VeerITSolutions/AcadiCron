<?php

namespace App\Http\Controllers;

use App\Models\FeeGroups;
use App\Models\FeeGroupsFeetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\FeeReminder;
use App\Models\FeeGroupType;
use App\Models\FeesReminder;
use App\Models\SchSettings;
use App\Services\MailSmsService;

class CronController extends Controller
{
    protected $cronKey;
    protected $mailSmsService;

    public function __construct(MailSmsService $mailSmsService)
    {
        // Load settings from the database
        $setting = SchSettings::first(); // Assuming your settings table has only one row
        $this->cronKey = $setting->cron_secret_key;
        $this->mailSmsService = $mailSmsService;
    }

    public function index($key = '')
    {
        if ($key !== "" && $this->cronKey === $key) {
            $this->autobackup($key);
            $this->feereminder($key);
        } else {
            return response('Invalid Key or Direct access is not allowed', 403);
        }
    }

    public function autobackup($key = '')
    {
        if ($key === $this->cronKey) {
            $backup = DB::getDoctrineSchemaManager()->createSchema();
            $filename = "db-" . now()->format('Y-m-d_H-i-s') . ".sql";

            Storage::disk('local')->put("backup/database_backup/{$filename}", $backup);

            return response('Database backup successful', 200);
        } else {
            return response('Invalid Key or Direct access is not allowed', 403);
        }
    }

    public function feereminder($key = '')
    {
        if ($key === $this->cronKey) {
            $setting = SchSettings::first();
            $feeReminders = FeesReminder::where('status', 1)->get();

            $studentList = [];

            foreach ($feeReminders as $feeReminder) {
                $date = $feeReminder->reminder_type == 'before' ?
                    now()->addDays($feeReminder->day)->format('Y-m-d') :
                    now()->subDays($feeReminder->day)->format('Y-m-d');

                $feesTypeReminders = FeeGroupsFeetype::getFeeTypeDueDateReminder($date);

                foreach ($feesTypeReminders as $reminder) {
                    $students = FeeGroupsFeetype::getFeeTypeStudents($reminder->fee_session_group_id, $reminder->id);

                    foreach ($students as $student) {
                        $student->due_date = $date;
                        $student->fee_type = $reminder->type;
                        $student->fee_code = $reminder->code;
                        $student->fee_amount = $reminder->amount;
                        $student->due_amount = $reminder->amount;
                        $student->deposit_amount = 0.00;

                        $feesArray = json_decode($student->amount_detail, true);
                        if (is_array($feesArray)) {
                            $depositAmount = array_reduce($feesArray, function ($carry, $fee) {
                                return $carry + ($fee['amount'] + $fee['amount_discount']);
                            }, 0);
                            $student->deposit_amount = number_format($depositAmount, 2, '.', '');
                            $student->due_amount = number_format($reminder->amount - $depositAmount, 2, '.', '');
                        }

                        $student->student_name = $this->getFullName($student, $setting);
                        $student->school_name = $this->getSchoolName();

                        if ($student->due_amount > 0) {
                            $studentList[] = $student;
                        }
                    }
                }
            }

            // Send reminders to all students
            foreach ($studentList as $student) {
                $this->mailSmsService->send('fees_reminder', $student);
            }

            return response('Fee reminders sent', 200);
        } else {
            return response('Invalid Key or Direct access is not allowed', 403);
        }
    }

    private function getFullName($student, $setting)
    {
        return "{$student->firstname} " . ($setting->middlename ? "{$student->middlename} " : "") . "{$student->lastname}";
    }

    private function getSchoolName()
    {
        return "Your School Name"; // Implement actual logic to fetch school name
    }
}
