@if($custom_field->id !== null)
    <script>
        $(document).ready(function() { 
            $('#customFieldType').trigger("change");
            setupSelect2Options()
        });
    </script>
@endif

<script>
    // options container
    var options = $('.options-container')

    // Default value
    var default_answer = "{{ $custom_field->default_answer }}"

    // Setup Select2 Options
    function setupSelect2Options() {
        // Get all the options
        var options = $('input[name^=option]').map(function(i, elem) {
            return $(elem).val();
        }).get();

        if(Array.isArray(options) && options.length !== 0) {
            $('#defaultValueInput').empty().trigger("change");
            var newOption = new Option("{{ __('messages.default_value') }}", null, false, false);
            $('#defaultValueInput').append(newOption).trigger('change');
        
            $(options).each(function(index, value) {
                if (default_answer === value) {
                    var newOption = new Option(value, value, true, true);
                } else {
                    var newOption = new Option(value, value, false, false);
                }
                $('#defaultValueInput').append(newOption).trigger('change');
            });
        }
    }

    // Add listener to addOption button
    $("#addOption").click(function () {
        var html = '';
        html += '<div class="option-row col-12">';
        html += '   <div class="input-group mb-3">';
        html += '       <input type="text" name="options[]" class="form-control m-input" autocomplete="off">';
        html += '       <div class="input-group-append">';
        html += '           <button type="button" class="btn btn-danger removeOption">x</button>';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        options.prepend(html);
    });

    // Add listener to removeOption button
    $(document).on('change', '.m-input', function () {
        setupSelect2Options();
    });

    // Add listener to removeOption button
    $(document).on('click', '.removeOption', function () {
        var value = $(this).closest('.input-group').find('.m-input').val();
        $(this).closest('.option-row').remove();
        setupSelect2Options()
    });

    $('#customFieldType').on('change', function() {
        var def = $('#defaultValueInput')
        // clear select
        var select = def.closest('.form-group').find('.select2').remove()
        
        switch (this.value) {
            case "Input":
                var newElement = $("<input type='text' />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" }).insertBefore(def);
                if (default_answer !== null || default_answer !== '') newElement.val(default_answer)
                def.remove()
                options.hide()
                break;
            case "TextArea":
                var newElement = $("<textarea />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" }).insertBefore(def);
                if (default_answer !== null || default_answer !== '') newElement.val(default_answer)
                def.remove()
                options.hide()
                break;
            case "Phone":
                var newElement = $("<input type='tel' />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" }).insertBefore(def);
                if (default_answer !== null || default_answer !== '') newElement.val(default_answer)
                def.remove()
                options.hide()
                break;
            case "Url":
                var newElement = $("<input type='url' />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" }).insertBefore(def);
                if (default_answer !== null || default_answer !== '') newElement.val(default_answer)
                def.remove()
                options.hide()
                break;
            case "Number":
                var newElement = $("<input type='number' />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" }).insertBefore(def);
                if (default_answer !== null || default_answer !== '') newElement.val(default_answer)
                def.remove()
                options.hide()
                break;
            case "Dropdown":
                // Setup Select Input
                var newSelect = $("<select></select>").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" });
                newSelect.insertBefore(def)
                newSelect.select2({
                    'placeholder': "{{ __('messages.default_value') }}"
                });

                // Remove old input
                def.remove()

                // Show options container
                options.show()
                break;
            case "Switch":
                var newElement = $("<input type='checkbox' />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value", style: "width: 20px;" }).insertBefore(def);
                if (default_answer !== null || default_answer !== '') newElement.val(default_answer)
                def.remove()
                options.hide()
                break;
            case "Date":
                var date = $("<input type='text' />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" }).insertBefore(def);
                date.flatpickr({
                    dateFormat: "Y-m-d",
                    defaultDate: default_answer,
                });
                def.remove()
                options.hide()
                break;
            case "Time":
                var time = $("<input type='text' />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" }).insertBefore(def);
                time.flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: default_answer,
                });
                def.remove()
                options.hide()
                break;
            case "DateTime":
                var datetime = $("<input type='text' />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" }).insertBefore(def);
                datetime.flatpickr({
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    defaultDate: default_answer,
                    onReady() { this.showTimeInput = true }
                });
                def.remove()
                options.hide()
                break;
            default:
                $("<input type='text' />").attr({ id: "defaultValueInput", class: "form-control", name: "default_value" }).insertBefore(def);
                def.remove()
                options.hide()
                break;
        }
    });
</script>