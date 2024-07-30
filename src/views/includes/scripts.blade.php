<script type="text/javascript">
    jQuery.extend({
        getCustomJSON: function(url) {
            var result = null;
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    result = data;
                }
            });
            return result;
        }
    });

    function detailFormatter(index, row, url) {
        var mydata = $.getCustomJSON("admin/dashboard");

        var html = [];
        $.each(row, function(key, value) {
            var data = $.grep(mydata, function(e) {
                return e.field == key;
            });

            if (typeof data[0] !== 'undefined') {

                html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
            }
        });

        return html.join('');

    }

    function operateFormatter(value, row, index) {
        var link = "<?php echo url('administration/master_data/divisi_departemen'); ?>";
        return [
            '<div class = "btn-group"> <a class="btn btn-sm btn-info btn-xs action" href="' +
            link + '/ubah/' + value + '">', '<i class="ft-edit mr-1"></i>Ubah', '</a>  ',
            '<a class="btn btn-sm btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menonaktifkan data?\')" href="' +
            link + '/nonaktif/' + value + '">', '<i class="ft-power mr-1"></i>Nonaktif',
            '</a> </div> ',
        ].join('');
    }

    function totalTextFormatter(data) {
        return 'Total';
    }

    function totalNameFormatter(data) {
        return data.length;
    }

    function totalPriceFormatter(data) {
        var total = 0;
        $.each(data, function(i, row) {
            total += +(row.price.substring(1));
        });
        return '$' + total;
    }
</script>

<script type="text/javascript">
    $(function() {
        var $tables = $('.x-bootstrap-table')
        $tables.each(function(_, table) {
            let $table = $(table)
            initTable($table)
        })
    });

    function refreshTable($table, config) {
        const url = new URL($table.attr('data-src'))
        let tableUrl = new URL($table.attr('data-src'))
        let configUrl = new URL($table.attr('data-src'))
        configUrl.searchParams.append("get_config", 1)
        configUrl.searchParams.append("origin_url", window.location.href)
        tableUrl.searchParams.append("origin_url", window.location.href)


    }

    function initTable($table, event = "") {
        const url = new URL($table.attr('data-src'))
        let tableUrl = new URL($table.attr('data-src'))
        let configUrl = new URL($table.attr('data-src'))
        let afterEffect = $table.attr('data-after-effect')
        configUrl.searchParams.append("get_config", 1)
        configUrl.searchParams.append("origin_url", window.location.href)
        tableUrl.searchParams.append("origin_url", window.location.href)

        const table_id = $table.attr('id')
        const id = $table.attr('id')
        const $filters = $($table.attr('data-filter-class'));
        tableUrl = $filters.toArray().reduce((tableUrl, i) => {
            const $i = $(i);
            tableUrl.searchParams.set($i.attr('name'), $i.val())
            return tableUrl
        }, tableUrl);

        if (event === "refresh") {
            $table.bootstrapTable('refresh', {
                url: tableUrl.href
            })
            return
        }

        const getConfig = $.get(configUrl.href).done(data => {
            const {
                tableConfig,
                filters
            } = data;
            $table.bootstrapTable({
                url: tableUrl.href,
                cookieIdTable: table_id,
                ...tableConfig,
                onLoadSuccess: window[afterEffect]
            });
            let filter_id = "#filter_container_" + table_id;
            $(filters).insertBefore(filter_id)
            $(filter_id).find('.select2').select2({
                placeholder: "Pilih opsi",
                width: '100%',
            })

            $table.on('expand-row.bs.table', function(e, index, row,
                $detail) {
                $detail.html(detailFormatter(index, row,
                    "alias_divisi_departemen"));
            });
        });
    }

    function applyFilter(e) {
        e.preventDefault()
        const $el = $(e.target)
        const $table = $($el.data('table-target'))
        const $filters = $($el.data('filter-class'))
        console.log("APPLY FILTER")

        // const $filters = $($table.attr('data-filter-class'));
        // console.log($el, $table, $filters)
        initTable($table, 'refresh');
    }

    function removeFilter(e) {
        e.preventDefault()
        const $el = $(e.target)
        const $table = $($el.data('table-target'))
        const $filters = $($el.data('filter-class'))
        console.log($filters);
        $filters.val("").trigger("change")
        // 	console.log(element)
        // });

        // const $filters = $($table.attr('data-filter-class'));
        // applyFilter(e)
    }

    async function ModalTable(table, url) {
        //
        let $table = $(table)

        const table_id = $table.attr('id')
        const id = $table.attr('id')
        let afterEffect = $table.attr('afterEffect') || ''
        $table.bootstrapTable('destroy')
        return await $.get(url + "?get_config=1").done(data => {
            let {
                filters,
                tableConfig
            } = data;
            $table.bootstrapTable({
                url: url,
                cookieIdTable: table_id,
                ...tableConfig,
                onLoadSuccess: window[afterEffect]
            });
            let filter_id = "#filter_container_" + table_id;
            $(filters).insertBefore(filter_id)
            $(filter_id).find('.select2').select2({
                placeholder: "Pilih opsi",
                width: '100%',
            })
            // setTimeout(function() {
            //     $table.bootstrapTable('resetView');
            // }, 200);

            $table.on('expand-row.bs.table', function(e, index, row, $detail) {
                $detail.html(detailFormatter(index, row,
                    "alias_divisi_departemen"));
            });
            return true;
        }).fail(function() {
            return false;
        });

    }

    function onchangeTable(table, url) {
        let $table = $(table)
        let tableUrl = url
        let configUrl = url
        let afterEffect = $table.attr('data-after-effect')
        // configUrl.searchParams.append("get_config", 1)
        configUrl.searchParams.append("origin_url", window.location.href)
        tableUrl.searchParams.append("origin_url", window.location.href)

        const table_id = $table.attr('id')
        const id = $table.attr('id')
        const $filters = $($table.attr('data-filter-class'));
        console.log("uwus");
        tableUrl = $filters.toArray().reduce((tableUrl, i) => {
            tableUrl.searchParams.set(i.name, i.value)
            return tableUrl
        }, tableUrl);

        $table.bootstrapTable('refresh', {
            url: tableUrl.href
        })
        return

    }
</script>

<script>
    $(function() {
        // Javascript to enable link to tab
        var hash = location.hash.replace(/^#/, ''); // ^ means starting, meaning only match the first hash
        if (hash) {
            $('.section-tab a[href="#' + hash + '"]').tab('show');
        }

        // Change hash for page-reload
        $('.nav-tabs a').on('shown.bs.tab', function(e) {
            window.location.hash = e.target.hash;
        })
        // summernote
        $('.summer').summernote({
            height: '200px',
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['undo'],
                ['redo']


            ],
            shortcuts: false,
            lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0',
                '3.0'
            ],
            popover: {
                table: [
                    ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                    ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                ],
                air: [
                    ['color', ['color']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'paragraph']],
                    ['table', ['table']],
                ]
            }
        });
        //popover
        $('[data-toggle="popover"]').popover({

        })
    });
</script>
<script>
    // Modal Configuration

    function isPromise(p) {
        return p && Object.prototype.toString.call(p) === "[object Promise]";
    }



    async function showModal(event) {
        const $el = $(event.target);
        const modal_target = $el.data('modal-target');
        const $modal = $(modal_target);
        const before_show = $modal.data('before-show');
        const modal_param = $el.data('modal-param');
        console.log(before_show);


        if (before_show) {
            let res;
            if (modal_param === '' || modal_param === undefined || modal_param === null) {
                res = window[before_show]();
            } else {
                res = ajaxItem(modal_param);

            }

            if (isPromise(res)) {
                $.LoadingOverlay("show");
                await res;
            }

            if (!res) {
                $.LoadingOverlay("hide");
                return;
            }
        }

        $modal.appendTo("body").modal('show');
        $.LoadingOverlay("hide");
    }



    function serializeFormData(array) {
        // console.log("BEFORE: ", array)
        return array.reduce(function(acc, input) {
            // console.log("SET: ", input)

            $('input[name="' + input['name'] + '"]').removeClass('invalid')

            let isArrayKey = (input['name'].endsWith('[]'))
            let key = isArrayKey ? input['name'].substr(0, input['name'].length - 2) : input[
                'name']

            if (!isArrayKey) {
                acc[key] = input['value'];
                return acc
            }

            if (isArrayKey) {
                if (!Array.isArray(acc[key])) {
                    acc[key] = []
                }
                acc[key] = acc[key].concat([input['value']]);
            }
            return acc;
        }, {});
    }

    const formSubmitConfig = {
        saveAndContinue: {
            swalConfirmation: {
                type: "info",
                title: 'Simpan',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                html: "Anda Yakin ?",
            },
            swalSuccessMessage: {
                title: 'Data berhasil disimpan',
            },
        },
        saveAndDraft: {
            swalConfirmation: {
                type: "info",
                title: 'Simpan sebagai draft?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                html: "Anda yakin ingin menyimpan data sebagai draft?",
            },
            swalSuccessMessage: {
                title: 'Draft berhasil disimpan',
            }
        },
        saveAndUpdate: {
            swalConfirmation: {
                type: "warning",
                title: 'Simpan Perubahan',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                html: "Anda Yakin ?",
            },
            swalSuccessMessage: {
                title: 'Perubahan berhasil disimpan',
            }
        }
    }

    function buttonFormSubmit(event, submitType) {
        event.preventDefault()
        console.log(submitType)

        const submitTypes = {
            "is_draft": 0,
            "is_update": 0,
        }

        const $el = $(event.target)


        if ($el.data('custom-action')) {
            const action = $el.data('action')
            const method = $el.data('method')
            const config = $el.data('config')
            console.log(config, "CONFIG")
            const data = {};
            config.element = $el
            console.log(config.element)
            sendAjaxRequest(action, method, data, config)
            return
        }


        const $form = $($el.parents('form'))
        const action = $form.attr('action')
        const method = $form.attr('method')
        const data = serializeFormData($form.serializeArray())
        console.log($el);
        console.log($form)
        console.log(data)

        const config = formSubmitConfig[submitType] ?? {}
        console.log(formSubmitConfig[submitType])

        if (submitType === "saveAndDraft") {
            submitTypes.is_draft = 1;
        }
        if (submitType === "saveAndUpdate") {
            submitTypes.is_update = 1;
        }

        if (window.main_form_data) {
            console.log()
            data.raw = {
                ...window.main_form_data
            }
        }
        data.submit_type = submitTypes;
        config.element = $el
        console.log(config.element)

        sendAjaxRequest(action, method, data, config)
    }

    // Form Handler
    function submitForm(event) {
        event.preventDefault()
        console.log("submitForm")
        console.log(event)
        const $target = $(event.target)
        const data = $target.serializeArray().reduceRight(function(acc, input) {
            acc[input['name']] = acc[input['value']]
            return acc;
        }, {})
        const method = $target.attr('method')
        const url = $target.attr('action')

        console.log(data, method, url)

        sendAjaxRequest(url, method, data)
        // $.LoadingOverlay("show");
    }

    function showFormValidationError({
        message,
        errors
    }) {
        Swal.fire({
            type: 'error',
            html: message,
        })

        for (const [key, value] of Object.entries(errors)) {
            console.log(`${key}: ${value}`);
            $('input[name="' + key + '"]').addClass('invalid')
            toastr["error"](value)
        }
    }

    async function poll(fn, fnCondition, ms) {
        let result = await fn();
        while (fnCondition(result)) {
            await wait(ms);
            result = await fn();
        }
        return result;
    }

    function wait(ms = 1000) {
        return new Promise(resolve => {
            console.log(`waiting ${ms} ms...`);
            setTimeout(resolve, ms);
        });
    }

    async function sendAjaxRequest(url, method, data = "", config = {}) {
        swal.fire(config.swalConfirmation || {
            type: 'warning',
            title: 'Insert Data',
            showCancelButton: true,
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak',
            html: "Anda Yakin ?",
        }).then((result) => {
            if (config.element) {
                if (result.dismiss == 'cancel') {
                    return false;
                } else {
                    if (config.element.data('redirect')) {
                        window.location.href = config.element.data('redirect')
                        return;
                    }
                }
            }
            console.log("OWO", result)
            if (result.value == true) {
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content'),
                    'Content-Type': config.contentType ?? "application/json",
                    'X-REQUEST-VIA': "form-wrapped"
                }
                $.LoadingOverlay('show')
                return $.ajax({
                    url: url,
                    headers: headers,
                    type: method,
                    data: JSON.stringify(data),
                    success: function(json) {
                        console.log(json)
                        if (json.swal) {
                            Swal.fire(json.swal).then(() => {
                                if (json.swal.redirectUrl) {
                                    window.location.href = json.swal
                                        .redirectUrl
                                }
                            })
                            return
                        }
                        if (json.status == "success") {
                            $.LoadingOverlay("hide");
                            Swal.fire(config.swalSuccessMessage)
                        } else {
                            $.LoadingOverlay("hide");
                            if (config.swalErrorMessage) {
                                Swal.fire(config.swalErrorMessage)
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    html: json.error_message,
                                })
                            }
                        }
                    },
                    error: function(res) {
                        const json = res.responseJSON
                        $.LoadingOverlay("hide");
                        if (res.status == 422) {
                            showFormValidationError(json)
                            return;
                        }
                        console.log(res)
                        if (config.swalFatalErrorMessage) {
                            Swal.fire(config.swalFatalErrorMessage)
                        } else if (json.error) {
                            Swal.fire({
                                type: 'error',
                                html: json.error.message,
                            })
                        } else {
                            if (json.message) {
                                Swal.fire({
                                    type: 'error',
                                    title: "Terjadi kesalahan.",
                                    html: json.message
                                })
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    html: "Terjadi kesalahan."
                                })
                            }
                        }
                    },
                    complete: () => {
                        $.LoadingOverlay('hide')
                    }
                });
            }
        });

    }

    // Table Handler
    function nestedPropertyByString(data, key) {
        var keys = key.split('.');
        // Iterate through the keys to access the nested property
        var result = data;
        for (var i = 0; i < keys.length; i++) {
            result = result[keys[i]];
            // Check if the property exists
            if (result === undefined) {
                // Handle the case where the property is not found
                console.log("Property not found");
                break;
            }
        }
        return result;
    }

    function relationshipColumnFormatter(value, row, index) {
        try {
            return nestedPropertyByString(row, this.field);
        } catch (error) {
            return undefined
        }
    }

    var config = {
        actionUrl: "",
        method: "",
        swalConfirmation: {},
        swalSuccessMessage: {},
        swalErrorMessage: {},
        swalFatalErrorMessage: {},
        swalAlwaysMessage: {},
    }

    async function actionCallback(action_config_name) {
        var config = window['form_actions'][action_config_name];
        console.log(config, action_config_name);
        Swal.fire(config.swalConfirmation).then(result => {
            if (result.value) {
                $.LoadingOverlay("show");
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
                $.ajax({
                    url: config.actionUrl,
                    headers: headers,
                    type: config.method,
                    success: function(json) {
                        console.log(json);
                        if (json.status == "success") {
                            $.LoadingOverlay("hide");
                            Swal.fire(config.swalSuccessMessage)
                        } else {
                            $.LoadingOverlay("hide");
                            if (config.swalErrorMessage) {
                                Swal.fire(config.swalErrorMessage)
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    html: json.error_message,
                                })
                            }
                        }
                    },
                    error: function() {
                        $.LoadingOverlay("hide");
                        if (config.swalFatalErrorMessage) {
                            Swal.fire(config.swalFatalErrorMessage)
                        } else {
                            Swal.fire({
                                type: 'error',
                                html: json.error.message,
                            })
                        }
                    }
                });
            }
        }).catch(swal.noop);
    }

    // CHange Pola Belanja
    function updatePolaBelanja(e) {
        e.preventDefault();
        const $el = $(e.target);
        let value = $el.val();
        let name = $el.attr('name');
        let pr_id = $el.data('pr-id');
        let url = "{{ route('admin.purchase_request_plan.update') }}";

        sendAjaxRequest(url, "POST", {
            "pr_num": pr_id,
            "name": name,
            "value": value,
        })
    }

    function joinPurchaseRequest() {
        let arr_pr = [];
        let url = "{{ route('admin.purchase_plan.create') }}";

        $('input[name="pr_number[]"]:checked').each(function() {
            arr_pr.push($(this).val());
        });

        if (arr_pr.length === 0) {
            Swal.fire({
                type: 'error',
                html: 'Purchase Request wajib dipilih minimal satu'
            });
            return;
        }

        window.location.href = url + "?data_pr=" + JSON.stringify({
            'data': arr_pr
        });
    }

    function ajaxDelete(id, url, table_id) {
        swal.fire({
            type: 'warning',
            title: 'Peringatan',
            html: 'Apakah anda yakin?',
            showCancelButton: true,

        }).then((result) => {
            if (result.value == true) {
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                $.ajax({
                    url: url,
                    headers: headers,
                    type: 'GET',
                    data: {
                        "id": id
                    },
                    beforeSend: function() {
                        $.LoadingOverlay("show");
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    },
                    success: function(json) {
                        $.LoadingOverlay("hide");
                        if (json.swal) {
                            Swal.fire(json.swal).then(() => {
                                if (json.swal.redirectUrl) {
                                    window.location.href = json.swal
                                        .redirectUrl
                                }
                            })
                            return
                        }
                        if (json.status == "success") {
                            swal.fire({
                                type: 'success',
                                title: 'Sukses',
                                html: 'Berhasil Hapus Data!',
                            }).then((result) => {
                                $('#' + table_id).bootstrapTable('refresh')
                            }).catch(swal.noop);
                        } else {
                            swal.fire({
                                type: 'error',
                                title: 'Error',
                                html: json.error_message,
                            });
                        }

                    },
                    error: function(error) {
                        $.LoadingOverlay("hide");
                        // console.log(error.responseJSON.message);
                        swal({
                            type: 'error',
                            title: 'Error',
                            html: error.responseJSON.message,
                        })
                    }
                })
            }
        });
    }

    function ajaxUploadTemp(e, id) {
        if (id == "") return;
        const $el = $(e.target)
        const $filename_target = $($el.data('target'))
        const $filename_preview = $($el.data('preview'))
        const files = $el.prop("files")
        if (files.length < 1) return;
        let form_data = new FormData()
        form_data.append('file_data', files[0]);
        $.ajax({
            url: "{{ route('admin.ajax_upload') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            beforeSend: function() {
                $.LoadingOverlay("show");
            },
            complete: function() {
                $.LoadingOverlay("hide");
            },
            success: function(json) {
                $.LoadingOverlay("hide");
                if (json.status == "success") {
                    $el.closest('.form-group').find('.preview_upload').css('pointer-events', 'auto');
                    let downloadUrl = json.file_path;
                    // $el.closest('.form-group').find('.preview_upload').attr('href', downloadUrl);
                    $el.closest('.form-group').find('.preview_upload').attr('data-url', downloadUrl);
                    $el.closest('.form-group').find('input#file_name').val(json.file);
                    $el.closest('.form-group').find('span#name_upload').text(json.file_name);
                    $el.closest('.form-group').find('input#name_upload').val(json.file_name);
                    $el.closest('.form-group').find('input#file_original_name').val(json.file_name);
                    //  bila sukses
                } else if (json.status == "error_val") {
                    swal({
                        type: 'error',
                        html: json.error_message.file_data[0],
                    });
                } else {
                    swal({
                        type: 'error',
                        html: json.error_message,
                    });
                }
            },
            error: function(res) {
                const json = res.responseJSON
                $.LoadingOverlay("hide");
                if (res.status == 422) {
                    showFormValidationError(json)
                    return;
                }
                if (config.swalFatalErrorMessage) {
                    Swal.fire(config.swalFatalErrorMessage)
                } else if (json.error) {
                    Swal.fire({
                        type: 'error',
                        html: json.error.message,
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        html: "Terjadi kesalahan."
                    })
                }
            }
        });
    }

    function openModal() {
        $('#importModal').appendTo("body").modal('show');
    }
</script>


<script>
    $(document).ready(function() {
        $(window.location.hash).click()
    })

    function selectTab(event) {
        window.location.hash = "#" + event.target.id
    }

    function update_oa(id) {
        var isChecked = $('#checkbox-' + id).prop('checked');

        console.log(isChecked, 'uwu', id);
        var requestData = {
            isChecked: isChecked
        };

        $.ajax({
            url: "{{ url('admin/resources/update-oa') }}/" + id,
            type: 'get',
            data: requestData,
            success: function(response) {},
            error: function(xhr, status, error) {}
        });
    }
</script>

<script>
    //formater
    // on input
    var commaCounter = 10;

    function formatInputCurrency(input) {
        var value = input.value.replace(/[^\d,]/g, ''); // Remove non-numeric and non-comma characters

        // Format number with separators
        value += '';

        for (var i = 0; i < commaCounter; i++) {
            value = value.replace('.', '');
        }

        var x = value.split('.');
        var y = x[0];
        var z = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(y)) {
            y = y.replace(rgx, '$1' + '.' + '$2');
        }
        commaCounter++;
        value = y + z;

        // Set the formatted value back into the input field
        input.value = value;

    }

    $(document).on('keypress input paste', '.number-separator', function(e) {
        if (/^-?\d*[,.]?(\d{0,3},)*(\d{3},)?\d{0,3}$/.test(e.key)) {
            var input = $(this);
            formatInputCurrency(this);
        } else {
            e.preventDefault();
            return false;
        }
    });

    function formatCurrency(value) {
        return number_format(value, 0, ',', '.'); // Adjusted to use three decimal places
    }

    function formatVolume(value) {
        return number_format(value, 3, ',', '.'); // Adjusted to use three decimal places
    }


    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };

        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }

        return s.join(dec);
    }


    function generateRandomString(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
</script>

{{-- remove element --}}
<script>
    function DateDMY(value) {

        var date = new Date(value);

        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        day = day < 10 ? '0' + day : day;
        month = month < 10 ? '0' + month : month;
        var formattedDate = day + '/' + month + '/' + year;

        return formattedDate;

    }

    function remove_elem(element) {
        const closestTableRow = element.closest('tr')
        closestTableRow.remove()
        // check if you have an item
        if (typeof calculateFooterRab === 'function') {
            calculateFooterRab();
        }
    }

    function clear_date(name) {
        $('[name="' + name + '"]').val('')
    }

    function setAjaxUserOption() {
        $('.ajax-user').select2({
            ajax: {
                url: '/admin/administrator/user-management/users',
                dataType: 'json',
                minimumInputLength: 3,
                delay: 250, // wait 250 milliseconds before triggering the request
                data: params => {
                    var query = {
                        option: true,
                        search: params.term,
                        type: 'hcms',
                    }
                    return query;
                },
                processResults: function(data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.result
                    };
                }
            }
        });
    }

    setAjaxUserOption()


    function setSelect2Ajax() {
        const $el = $('.select2-ajax')
        const url = $el.data('url');
        const type = $el.data('type');
        const delay = $el.data('delay') || 250;
        const multiple = $el.attr('multiple') || null;
        console.log($el, multiple)
        $el.select2({
            ajax: {
                url: url,
                dataType: 'json',
                minimumInputLength: 3,
                tags: !!multiple,
                tokenSeparators: [',', ' '],
                delay: delay, // wait 250 milliseconds before triggering the request
                data: params => {
                    var query = {
                        option: true,
                        search: params.term,
                        type: type,
                    }
                    return query;
                },
                processResults: function(data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.result
                    };
                }
            }
        });
    }

    setSelect2Ajax()

    function add_user_option(event) {
        event.preventDefault()

        const $el = $(event.target)
        const appendTarget = $el.data('render-target')
        let elem = `
            <div class="form-group row signature_tppl_row" data-id="0">
                <div class="col-md-12">
                    <div class="d-flex align-items-center justify-content-left mt-4">
                        <span class="btn-sm btn btn-danger" onclick="RemoveSignatureTppl(this);"><i
                            class="ft ft-trash"></i>
                        </span>
                        <div class="col-8 col-md-4">      
                            @include('components.options.user', [])
                        </div>
                        <div class="col-2">
                            <select class="form-control" name="approval_type[]" id="approval_type">
                                <option value="verifikator">Verifikator Saja</option>
                                <option value="verifikator-signer">Verifikator dan Tanda Tangan</option>
                                <option value="signer">Penanda Tangan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>`;
        $(appendTarget).append(elem);
        setAjaxUserOption()
    }

    function section_see_more(event) {
        event.preventDefault()
        $target = $(event.target)
        $container = $($target.data('target'))
        console.log($target, $container)
        $container.toggleClass('enlarge')
    }

    function toggleFloaters(event) {
        event.preventDefault()
        $target = $(event.target)
        $blueprint = $($target.data('blueprint'))
        $container = $($target.data('container'))

        $container.toggleClass('col-md-4 d-md-none')
        $blueprint.toggleClass('col-md-8 col-md-12')
        $target.toggleClass('btn-show-floaters btn-hide-floaters')
        $target.toggleClass('btn-info btn-danger')
        if ($target.hasClass('btn-info')) {
            $target.children('.material-symbols-outlined').text('keyboard_double_arrow_left')
        }
        if ($target.hasClass('btn-danger')) {
            $target.children('.material-symbols-outlined').text('keyboard_double_arrow_right')
        }
    }
</script>
