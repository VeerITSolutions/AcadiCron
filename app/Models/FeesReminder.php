<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FeesReminder extends Model
{
    protected $table = 'fees_reminder'; // Define the table name if it doesn't follow the convention

    protected $fillable = ['type', 'is_active']; // Add other fillable fields as needed

    /**
     * Get the fee reminder by id or active status.
     *
     * @param int|null $id
     * @param int|null $active
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getFeeReminder($id = null, $active = null)
    {
        $query = self::query();

        if ($active !== null) {
            $query->where('is_active', $active);
        }

        if ($id !== null) {
            return $query->find($id);
        } else {
            return $query->orderBy('id')->get();
        }
    }

    /**
     * Add or update fee reminder.
     *
     * @param array $data
     * @return int|bool
     */
    public function addOrUpdateFeeReminder($data)
    {
        DB::beginTransaction();

        try {
            $existingReminder = self::where('type', $data['type'])->first();

            if ($existingReminder) {
                $existingReminder->update($data);
                $message = 'Updated fee reminder with ID ' . $existingReminder->id;
                $action = 'Update';
                $this->log($message, $existingReminder->id, $action);
                $id = $existingReminder->id;
            } else {
                $newReminder = self::create($data);
                $message = 'Inserted new fee reminder with ID ' . $newReminder->id;
                $action = 'Insert';
                $this->log($message, $newReminder->id, $action);
                $id = $newReminder->id;
            }

            DB::commit();
            return $id;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Update fee reminder.
     *
     * @param array $data
     * @return int|bool
     */
    public function updateFeeReminder($data)
    {
        DB::beginTransaction();

        try {
            $feeReminder = self::find($data['id']);
            if ($feeReminder) {
                $feeReminder->update($data);
                $message = 'Updated fee reminder with ID ' . $data['id'];
                $action = 'Update';
                $this->log($message, $data['id'], $action);
            }

            DB::commit();
            return $data['id'];
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Update fee reminders in batch.
     *
     * @param array $updateArray
     * @return bool
     */
    public function updateBatch($updateArray)
    {
        DB::beginTransaction();

        try {
            if (!empty($updateArray)) {
                // Laravel doesn't have update_batch like CodeIgniter, so use raw query
                DB::table($this->table)->upsert($updateArray, ['id'], array_keys($updateArray[0]));
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Log action
     *
     * @param string $message
     * @param int $recordId
     * @param string $action
     */
    protected function log($message, $recordId, $action)
    {
        // Implement your logging logic here
        // Log::info($message); or DB insert into logs table
    }
}
