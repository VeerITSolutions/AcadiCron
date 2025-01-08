<style type="text/css">
    .attachment-block .text-green {
        color: #3498db !important;
    }
</style>

@php
    $myRole = app('App\Libraries\CustomLib')->getStaffRole(); // Assuming you have a custom library
    $role = json_decode($myRole);
    $staffId = $role->id == 7 ? request()->input('staff_id') : $staff_id;
@endphp

<div class="box-header text-center">
    <i class="fa fa-angle-left datearrow"
        onclick="get_weekdates('pre_week', '{{ $prev_week_start }}', '{{ $staffId }}')"></i>
    <h3 class="box-title bmedium">
        {{ $this_week_start . ' ' . __('to') . ' ' . $this_week_end }}
    </h3>
    <i class="fa fa-angle-right datearrow"
        onclick="get_weekdates('next_week', '{{ $next_week_start }}', '{{ $staffId }}')"></i>
    <input type="hidden" id="this_week_start" value="{{ $this_week_start }}">
</div>

<div class="table-responsive">
    @if (!empty($timetable))
        <table class="table table-stripped">
            <thead>
                <tr>
                    @php $dayCounter = 0; @endphp
                    @foreach ($timetable as $tmKey => $tmValue)
                        @php
                            $newDate1 = app('App\Libraries\CustomLib')->dateFormatToYYYYMMDD($this_week_start);
                            $nextDate = date('Y-m-d', strtotime($newDate1 . ' +' . $dayCounter . ' day'));
                            $dayCounter++;
                        @endphp
                        <th class="text text-center">
                            {{ __(strtolower($tmKey)) }}<br />
                            <span class="bmedium">
                                {{ date(app('App\Libraries\CustomLib')->getSchoolDateFormat(), strtotime($nextDate)) }}
                            </span>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @php $dayCounter = 0; @endphp
                    @foreach ($timetable as $tmKey => $tmValue)
                        @php
                            $newDate1 = app('App\Libraries\CustomLib')->dateFormatToYYYYMMDD($this_week_start);
                            $newDate = date('Y-m-d', strtotime($newDate1 . ' +' . $dayCounter . ' day'));
                            $dayCounter++;
                        @endphp
                        <td class="text text-center" width="14%">
                            @if (empty($tmValue))
                                <div class="attachment-block clearfix">
                                    <b class="text text-center">{{ __('Not') }} <br>{{ __('Scheduled') }}</b><br>
                                </div>
                            @else
                                @foreach ($tmValue as $tmK => $tmKue)
                                    @php
                                        $subjectGroupSubjectClassSection = app(
                                            'App\Models\LessonPlan',
                                        )->getSubjectGroupClassSectionsId(
                                            $tmKue->class_id,
                                            $tmKue->section_id,
                                            $tmKue->subject_group_id,
                                        );

                                        $subjectSyllabus = app('App\Models\Syllabus')->getSubjectSyllabusData(
                                            $tmKue->subject_group_subject_id,
                                            date('Y-m-d', strtotime($newDate)),
                                            $role->id,
                                            $staffId,
                                            $tmKue->time_from,
                                            $tmKue->time_to,
                                            $subjectGroupSubjectClassSection->id ?? null,
                                        );

                                        $action = $subjectSyllabus[0]['total'] > 0 ? $subjectSyllabus[0]['id'] : 0;
                                    @endphp

                                    @if ($action)
                                        <div id="hide_{{ $action }}">
                                            <a class="btn btn-default btn-xs pull-left" data-toggle="tooltip"
                                                title="{{ __('View') }}"
                                                onclick="get_subject_syllabus({{ $action }})">
                                                <i class="fa fa-reorder"></i>
                                            </a>
                                            @can('manage_lesson_plan', 'edit')
                                                <a class="btn btn-default btn-xs pull-left" data-toggle="tooltip"
                                                    title="{{ __('Edit') }}"
                                                    onclick="subject_syllabusedit({{ $action }})">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-default btn-xs pull-left" data-toggle="tooltip"
                                                    title="{{ __('Delete') }}"
                                                    onclick="subject_syllabusdelete(
                                                       '{{ $action }}',
                                                       '{{ $tmKue->subject_group_subject_id }}',
                                                       '{{ $tmKue->time_from }}',
                                                       '{{ $tmKue->time_to }}',
                                                       '{{ app('App\Libraries\CustomLib')->dateFormat($newDate) }}',
                                                       '{{ $subjectGroupSubjectClassSection->id }}')">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    @else
                                        @can('manage_lesson_plan', 'add')
                                            <a class="btn btn-default btn-xs pull-left" data-toggle="tooltip"
                                                title="{{ __('Add') }}"
                                                onclick="add_syllabus(
                                                   '{{ $tmKue->subject_group_subject_id }}',
                                                   '{{ $tmKue->time_from }}',
                                                   '{{ $tmKue->time_to }}',
                                                   '{{ date(app('App\Libraries\CustomLib')->getSchoolDateFormat(), strtotime($newDate)) }}',
                                                   '{{ $subjectGroupSubjectClassSection->id }}',
                                                   '{{ $staffId }}')">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        @endcan
                                    @endif

                                    <div class="attachment-block clearfix">
                                        <b class="text-green">{{ __('Subject') }}: {{ $tmKue->subject_name }}
                                            @if (!empty($tmKue->subject_code))
                                                ({{ $tmKue->subject_code }})
                                            @endif
                                        </b><br>
                                        <strong class="text-green">{{ __('Class') }}:
                                            {{ $tmKue->class }}({{ $tmKue->section }})</strong><br>
                                        <strong class="text-green">{{ $tmKue->time_from }}</strong>
                                        <b class="text text-center">-</b>
                                        <strong class="text-green">{{ $tmKue->time_to }}</strong><br>
                                        <strong class="text-green">{{ __('Room No') }}:
                                            {{ $tmKue->room_no }}</strong><br>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            {{ __('No Record Found') }}
        </div>
    @endif
</div>
