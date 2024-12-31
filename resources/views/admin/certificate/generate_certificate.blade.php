<style type="text/css">
    * {
        padding: 0;
        margin: 0;
    }

    body {
        font-family: 'arial';
    }

    .tc-container {
        width: 100%;
        position: relative;
        text-align: center;
        padding: 2%;
    }

    .tc-container tr td {
        vertical-align: bottom;
    }

    .tc-container tr td h1,
    h2,
    h3 {
        margin-top: 0;
        font-weight: normal;
    }

    .tcmybg {
        background: top center;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 1;
    }
</style>

@foreach ($students as $student)
    @php
        // Assume $certificate is an object
        $certificateText = $certificate->certificate_text;

        // Replace placeholders in certificate text
        $placeholders = [
            '[name]' => '[name]',
            '[present_address]' => '[current_address]',
            '[guardian]' => '[guardian_name]',
            '[phone]' => '[mobileno]',
        ];
        $certificateText = str_replace(array_keys($placeholders), array_values($placeholders), $certificateText);

        foreach ($student as $key => $value) {
            if (in_array($key, ['dob', 'admission_date', 'created_at']) && $value != '0000-00-00' && $value != '') {
                $value = date(config('school.date_format'), strtotime($value));
            }
            $certificateText = str_replace("[$key]", $value, $certificateText);
        }
    @endphp

    <div class="tc-container" style="position: relative; text-align: center; font-family: 'arial';">
        @if (!empty($certificate->background_image))
            <img src="{{ asset('uploads/certificate/' . $certificate->background_image) }}"
                style="width: 100%; height: 100vh" />
        @endif

        <table width="100%" cellspacing="0" cellpadding="0"
            style="position: absolute; top: 0; margin-left: auto; margin-right: auto; left: 0; right: 0; width: {{ $certificate->content_width }}px">
            <tr>
                <td style="position: absolute; right: 0;">
                    @if ($certificate->enable_student_image == 1)
                        <img style="position: relative; top: {{ $certificate->enable_image_height }}px;"
                            src="{{ asset($student->image) }}" width="100" height="auto">
                    @endif
                </td>
            </tr>
            <tr>
                <td valign="top"
                    style="text-align: left; position: relative; top: {{ $certificate->header_height }}px">
                    {{ $certificate->left_header }}</td>
                <td valign="top"
                    style="text-align: center; position: relative; top: {{ $certificate->header_height }}px">
                    {{ $certificate->center_header }}</td>
                <td valign="top"
                    style="text-align: right; position: relative; top: {{ $certificate->header_height }}px">
                    {{ $certificate->right_header }}</td>
            </tr>
            <tr>
                <td colspan="3" valign="top"
                    style="position: relative; top: {{ $certificate->content_height }}px">
                    <p style="font-size: 14px; line-height: 24px; text-align: center;">{!! $certificateText !!}</p>
                </td>
            </tr>
            <tr>
                <td valign="top"
                    style="text-align: left; position: relative; top: {{ $certificate->footer_height }}px">
                    {{ $certificate->left_footer }}</td>
                <td valign="top"
                    style="text-align: center; position: relative; top: {{ $certificate->footer_height }}px">
                    {{ $certificate->center_footer }}</td>
                <td valign="top"
                    style="text-align: right; position: relative; top: {{ $certificate->footer_height }}px">
                    {{ $certificate->right_footer }}</td>
            </tr>
        </table>
    </div>
@endforeach
