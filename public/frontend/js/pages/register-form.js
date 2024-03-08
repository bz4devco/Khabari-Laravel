$(document).ready(function () {
    $("#gender").on("change", function () {
        if ($(this).val() == 0) {
            serviceStatus();
        } else {
            $("#service_status_container").html("");
        }
    });

    if($('#service_status_container').attr('data-old') != null || undefined || ''){
        serviceStatus();
    }else{
        $("#service_status_container").html("");
    }
});

function serviceStatus() {
    $("#service_status_container").append(`
        <div class="form-group">
            <label for="service_status">وضعیت نظام وظیفه</label>
            <select class="form-control form-control-sm" name="service_status" id="service_status">
                <option disabled selected>لطفاًوضعیت نظام وظیفه خود را انتخاب کنید</option>
                <option value="0" @if(old('service_status') == 0) selected @endif >درحال ادامه تحصیل</option>
                <option value="1" @if(old('service_status') == 1) selected @endif >معافیت</option>
                <option value="2" @if(old('service_status') == 2) selected @endif >پایان خدمت</option>
            </select>
           `+
            errorMessage
           +`
        </div>
        `);
}
