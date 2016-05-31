var data = [];
jQuery(function ($) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

//    $("#toolbar").append('<div class="btn-wrapper"><button class="btn btn-small btn-success" data-task="new"><span class="icon-new icon-white"></span> New</button></div>');
    $("#toolbar").append('<div class="btn-wrapper"></div>');
    $("#calendar").appendTo(".btn-wrapper");
    $(".mask").mask("99:99");
    $("input, select").on('focus', function () {
        $(this).removeClass("invalid");
    });

    $.ajax({
        url: base + 'api/programepisodes'
        , success: function (d) {
            $.each(d.items, function () {
                $("#program-list").append('<option value="' + this.id + '">' + this.name + '</option>');
                data.push(this);
            });
            $("#program-list").select2({
                dir: "rtl"
            });
            $("#program-list").on('change', function (e) {
                selected = $("#program-list").find("option:selected").val();
                if (selected == 0) {
                    $("input[name=title]").removeClass('disabled');
                    $("#episode-list").addClass('disabled');
                } else {
                    $("input[name=title]").addClass('disabled').val($("#program-list").find("option:selected").text());
                    $.ajax({
                        url: base + 'api/programepisodes/' + selected
                        , success: function (d) {
                            $("#episode-list").find("option:nth-child(n+2)").remove();
                            $.each(d.items, function () {
                                $("#episode-list").append('<option value="' + this.id + '">' + this.title + '</option>');
                            });
                            $("#episode-list").removeClass('disabled');
                            $("#episode-list").on('change', function (e) {
                                eSelected = $("#episode-list").find("option:selected").val();
                                if (eSelected == 0) {
                                    $("input[name=subtitle]").removeClass('disabled');
                                } else {
                                    $("input[name=subtitle]").addClass('disabled').val($("#episode-list").find("option:selected").text());
                                }
                            });
                        }
                    });
                }
            });
        }
    });
    // Delegations
    $(document).on('click', "[data-task]", function (e) {
        var task = $(this).attr('data-task');
        switch (task) {
            default:
                toast('error', 'Unknown Error!');
                break;
            case 'new':
                ///
                break;
            case 'add':
                var d = $("tr.edit").find("input, select").serialize();
                var dobj = $("tr.edit").find("input, select").serializeObject();
                addItem(d, dobj);
                break;
            case 'load':
                var date = $("input[name=calendar]").val();
                load(date);
                break;
        }
        e.preventDefault();
    });
    $(document).on('click', "a.delete", function (e) {
        var id = $(this).attr('data-id');
        if (confirm('Are you sure you want to permanently delete this item?')) {
            $.ajax({
                url: base + 'api/schedules/' + id
                , type: 'delete'
                , success: function (d) {
                    load();
                }
            })
        }
        e.preventDefault();
    });

    // Functions
    function toast(type, message) {
        toastr[type](message);
    }

    function addItem(data, dataObject) {
        var e = [];
        if (dataObject.program_id == 0 && dataObject.title == "") {
            $("input[name=title]").addClass("invalid");
            e.push('Program Title');
        }
        if (dataObject.start === "" || dataObject.start == null) {
            $("input[name=start]").addClass("invalid");
            e.push('Start');
        }
        if (dataObject.duration === "" || dataObject.duration == null) {
            $("input[name=duration]").addClass("invalid");
            e.push('Duration');
        }
        if (e.length > 0) {
            for (var i = 0; i < e.length; i++)
                toast('error', e[i] + ' is required.');
            return false;
        } else {
            $.ajax({
                url: base + 'api/schedules/' + $("#date").val()
                , type: 'post'
                , data: data
                , success: function (d) {
                    if (typeof d === "object") {
                        toast('success', d.msg);
                        cleanForm();
                        load($("input[name=calendar]").val());
                    } else
                        toast('error', d);
                }
                , error: function (e) {
                    toast('error', JSON.parse(e.responseText).msg);
                }
            })
        }
    }

    var $row = '<tr><td>{i}</td><td>{revision}</td><td class="title">{title}</td><td class="subtitle">{subtitle}</td><td class="start">{start}</td><td class="duration">{duration}</td><td class="state">{state}</td><td class="program">{program}</td><td class="created">{created}</td></tr>';
    function load(date) {
        date = (typeof date === "undefined" || date === null || date === "") ? today : date;
        $.ajax({
            url: base + 'api/schedules/' + date
            , success: function (d) {
                $(".schedule-title span").text(date); // Set title
                $table = $("#schedule-table tbody");
                $table.find("tr").not(".edit").slideUp().remove();
                if (d.items.length) {
                    $.each(d.items, function (i) {
                        console.log(this.state);
                        $item = $row.replace(/{i}/, (i + 1))
                                .replace(/{revision}/, this.revision)
                                .replace(/{title}/, this.title)
                                .replace(/{subtitle}/, this.subtitle)
                                .replace(/{start}/, this.start.split(" ")[1])
                                .replace(/{duration}/, this.duration)
                                .replace(/{state}/, (this.state == 1) ? 'Published' : 'Unpublished')
                                .replace(/{program}/, '<a href="' + base + 'programs/' + this.episode + '" target="_blank"><i class="icon-link"></i></a>&nbsp;&nbsp;<a class="delete" data-id="' + this.id + '" href="#"><i class="icon-trash"></i></a>')
                                .replace(/{created}/, this.created);
                        $table.append($item);
                    });
                    var nextStart = createTime(processTime(d.items[d.items.length - 1].start.split(" ")[1]) + processTime(d.items[d.items.length - 1].duration));
                    $("input[name=start]").val(nextStart);
                }
            }
        });
    }
    load();
    function cleanForm() {
        $("#program-list").val("0").trigger('change.select2');
        $("input[name=title], input[name=subtitle], input[name=duration], input[name=start]").val('');
        $("input[name=title]").removeClass("disabled");
        $("#episode-list").find("option:nth-child(n+2)").remove();
        $("#episode-list").val("0").trigger('change.select2');
    }
    function zeroFill(number, size) {
        var number = number.toString();
        while (number.length < size)
            number = "0" + number;
        return number;
    }

    function processTime(time) {
        if (typeof time !== 'undefined') {
            var times = time.split(":");
            var hours = times[0];
            var minutes = times[1];
            var seconds = times[2];
            seconds = parseInt(seconds, 10) + (parseInt(minutes, 10) * 60) + (parseInt(hours, 10) * 3600);
        } else {
            var seconds = null;
        }
        return seconds;
    }

    function createTime(timestamp, showSign) {
        var output;
        var sign;
        showSign = (typeof showSign !== 'undefined') ? true : false;
        if (typeof timestamp !== 'undefined') {
            sign = (timestamp != Math.abs(timestamp)) ? '-' : '+';
            timestamp = Math.abs(timestamp);
            var time = new Date(0, 0, 0, 0, 0, timestamp, 0);
            var hours = zeroFill(time.getHours(), 2);
            var minutes = zeroFill(time.getMinutes(), 2);
            var seconds = zeroFill(time.getSeconds(), 2);
            output = hours + ":" + minutes + ":" + seconds;
            output = (showSign) ? output + sign : output;
        }
        return output;
    }
});

jQuery(window).load(function ($) {
//    jQuery(".has-suggest").chosen("destroy");

});
jQuery.fn.serializeObject = function () { // serializeArray - serialize form as an array instead of default object
    var o = {};
    var a = this.serializeArray();
    jQuery.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};