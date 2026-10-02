@extends('admin.master')
@section('css')
<style type="text/css">
    .flot-x-axis div,
    .flot-y-axis div{ font-size: 11px !important; }
    .report_part2 .graph_choice .income .box:after,
    .report_part2 .graph_choice .orders .box:after { border-color:#fff; }
    .report_part2 .graph_choice .income .box {
        background-color: #7cb7da;
        border-color: #7cb7da;
    }
    .report_part2 .graph_choice .income {
        color:#4487af;
    }
    .report_part2 .graph_choice .orders {
        color:#e02458;
    }
    .report_part2 .graph_choice .orders .box {
        background-color: #f82e66;
        border-color: #f82e66;
    }
</style>
@endsection
@section('content')
    <section class='report_part1'>
        <div class='paper_style1'>
            <div class='title_style1'>
                <p class='title1'>جستجو و فیلتر گزارش</p>
            </div><!--title_style1-->
            <hr class='hr_style1 margint5 marginb15' />

            @if(session('alarm'))
                <div class="result_style2 sign e">
                    <div class="text icon">{{session('alarm')}}</div>
                </div>
            @endif

            <form id='frm_article_search' method='get' action='{{route('admin.statistic.index')}}'>
                <div class='form_style2'>
                    <ul class='list clearfix'>
                        <li class='item fright width50'>
                            <p class='field_label'>از تاریخ :</p>
                            <input type='text' name='s_date_from' id='s_date_from' data-date-picker value='{{$data['date_from']}}' class='tcenter' autocomplete='off' >
                        </li>
                        <li class='item fright width50 nospace'>
                            <p class='field_label'>تا تاریخ :</p>
                            <input type='text' name='s_date_to' id='s_date_to' data-date-picker value='{{$data['date_to']}}' class='tcenter' autocomplete='off' >
                        </li>
                    </ul>
                </div><!--form_style2-->
                <hr class='hr_style1 margint5 marginb10'/>
                <div class='btn_group_style1' id='viewport1'>
                    <ul class='list clearfix'>
                        <li class='item fright'>
                            <input type='submit' value='جستجو نمائید' class='btn_style2 green'>
                        </li>
                        
                        <li class='item fright'><a href="{{route('admin.statistic.index')}}" class='btn_style2'>لغو جستجو</a></li>
                    </ul>
                </div><!--btn_group_style1-->
            </form>
        </div><!--paper_style1-->
    </section><!--report_part1-->

    <section class='report_part2'>
    <div class='paper_style1'>
        <div class='title_style1 marginr15'>
            <p class='title1'>نمودار درآمدها و فروش سایت</p>
            <p class='title2'>__ محور افقی : تاریخ  (روز / ماه) | محور عمودی : درآمد برحسب تومان</p>
        </div><!--title_style1-->
           
        <hr class='hr_style2 margint30' />
        
        <div class='graph_choice'>
            <label class='checkradio_style1 noselect tright fright marginl30 marginr15 income'><input type='checkbox' name='graph[]' value='income' checked><span class='box'></span>گزارش درآمدها</label>
            <label class='checkradio_style1 noselect tright fright marginl30 orders'><input type='checkbox' name='graph[]' value='orders' checked><span class='box'></span>گزارش فروش</label>
        </div>
        
        <hr class='hr_style2 margint30' />
        
        <div class='chart_holder'>
            <div class='chart_style1'></div>
        </div>

        <hr class='hr_style2 margint20' />        
    </div>
</section>

<section class='report_part3'>
    <div class='paper_style1'>    
        <ul class='clearfix form_style2'>
            <li class='item width100 fright'>
                <div class='table_style2' style='border: solid 1px #eee;'>
                    <table class='price_list width100 margin_auto'>
                        <tbody>
                            <tr>
                                <th class='width50 cl_blue'>درآمد ها - پرداخت آنلاین</th>
                                <td class='width50 fontsize1_2'><i data-mvwc>{{$data['sumPayOnline']}}</i> تومان</td>
                            </tr>
                            {{-- <tr>
                                <th class='width50 cl_blue'>درآمد ها - پرداخت بانکی</th>
                                <td class='width50 fontsize1_2'> تومان</td>
                            </tr> --}}
                            <tr>
                                <th class='width50 cl_blue'>درآمد ها - پرداخت با موجودی</th>
                                <td class='width50 fontsize1_2'><i data-mvwc>{{$data['sumPayBalance']}}</i> تومان</td>
                            </tr>
                            <tr>
                                <th class='width50 cl_blue'>درآمد ها - پرداخت حضوری</th>
                                <td class='width50 fontsize1_2'><i data-mvwc>{{$data['sumPayDoor']}}</i> تومان</td>
                            </tr>
                            <tr style='background-color:rgba(0,0,0,0.08);'>
                                <th class='width50 cl_green2' style='font-size:1.35rem;'>مجموع درآمد ها با کسر مرجوعی ها</th>
                                <td class='width50 fontsize1_2 letter1' style='font-size:1.4rem;color: #25ab8c;'><i data-mvwc>{{$data['sumPayTotal']}}</i> تومان</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--table_style2-->
            </li>
        </ul>
    </div><!--paper_style-->
</section><!--report_part3-->
@endsection

{{--Active Menu--}}
@section('admin.statistic.index','active')
{{--End Active Menu--}}

@section('datePicker')
    @include('admin.developer.datepicker')
@endsection

@section('js')
<script type="text/javascript" src="{{asset('assets/admin/_plugins/flot/jquery.flot.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/flot/jquery.flot.categories.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/flot/jquery.flot.navigate.min.js')}}"></script>
<script>
$(document).ready(function() {
        var previousPoint2 = null;
        //var data2 = [['14/3',0],['15/3',0],['16/3',120],['17/3',370],['18/3',1500],['19/3',120],['20/3',0],['21/3',20000],['22/3',1656],['23/3',0],['24/3',10000],['25/3',0],['26/3',0],['27/3',0],['28/3',0],['29/3',0],['30/3',10000],['31/3',0],['1/4',0],['2/4',0],['3/4',10000],['4/4',0],['5/4',0],['6/4',0],['7/4',0],['8/4',0],['9/4',15000],['10/4',0],['11/4',10060],['12/4',0],['4/13',0]];
        var data1 = [
            @foreach($data['chartsOne'] as $chart)
            [ '{{ShowDateForFlotChart($chart->date)}}','{{$chart->total_price}}' ],
            @endforeach
        ];
        var data2 = [
            @foreach($data['chartsTwo'] as $chartTwo)
            [ '{{ShowDateForFlotChart($chartTwo->date)}}','{{$chartTwo->total_quantity}}' ],
            @endforeach
        ];
        
        var data = [{
                data: data1,
                lines: {
                    fill: 0.2,
                    lineWidth: 0,
                },
                color: ['#BAD9F5'],
                unit:'تومان'
            }, {
                data: data1,
                points: {
                    show: true,
                    fill: true,
                    radius: 4,
                    fillColor: "#9ACAE6",
                    lineWidth: 2
                },
                color: '#9ACAE6',
                shadowSize: 1,
                unit:'تومان'
            }, {
                data: data1,
                lines: {
                    show: true,
                    fill: false,
                    lineWidth: 3
                },
                color: '#9ACAE6',
                shadowSize: 0,
                unit:'تومان'
            }, {
                data: data2,
                lines: {
                    show: true,
                    fill: false,
                    lineWidth: 2
                },
                color: '#f791ac',
                shadowSize: 0,
                unit:'سفارش'
            },{
                data: data2,
                points: { show: true,radius: 3 },
                color: '#F82E66',
                unit:'سفارش'
            }];
        var option = {
            xaxis: {
                tickLength: 0,
                tickDecimals: 0,
                mode: "categories",
                min: 0,
                max: 10,
                font: {
                    lineHeight: 35,
                    style: "normal",
                    variant: "small-caps",
                    color: "#6F7B8A",
                },
                panRange: false
            },
            yaxis: {
                ticks: 5,
                tickDecimals: 0,
                tickColor: "#eee",
                font: {
                    lineHeight: 14,
                    style: "normal",
                    variant: "small-caps",
                    color: "#6F7B8A",
                },
                panRange: false,
                tickFormatter: function numberWithCommas(x) {
                    return number_format(x);
                }
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#eee",
                borderColor: "#eee",
                borderWidth: 1
            },
            zoom: {
                interactive: false
            },
            pan: {
                interactive: true,
                dragCursor: "move"
            }
        };
        
        var $chart_style1 = $.plot($(".chart_style1"),data,option);
        var plot_width_each_dot = $chart_style1.width() / 10;  
        var plot_scroll_x = (data1.length - 10) * plot_width_each_dot;
        $chart_style1.pan({left:plot_scroll_x,top:0});
        
        // hover action
        $(".chart_style1").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint2 != item.dataIndex) {
                    previousPoint2 = item.dataIndex;
                    $(".tooltip_style1").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
                    var text = number_format(item.datapoint[1])+" "+item.series.unit;
                    showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1],text);
                }
            }else{
                $(".tooltip_style1").hide(0);
                previousPoint2 = null;
            }
        });        
        
        $("input[name='graph[]']").change(function(){
            if( $("input[name='graph[]'][value='income']").prop("checked") && $("input[name='graph[]'][value='orders']").prop("checked")){
                var data = [{
                    data: data1,
                    lines: {
                        fill: 0.2,
                        lineWidth: 0,
                    },
                    color: ['#BAD9F5'],
                    unit:'تومان'
                }, {
                    data: data1,
                    points: {
                        show: true,
                        fill: true,
                        radius: 4,
                        fillColor: "#9ACAE6",
                        lineWidth: 2
                    },
                    color: '#9ACAE6',
                    shadowSize: 1,
                    unit:'تومان'
                }, {
                    data: data1,
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 3
                    },
                    color: '#9ACAE6',
                    shadowSize: 0,
                    unit:'تومان'
                }, {
                data: data2,
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 2
                    },
                    color: '#f791ac',
                    shadowSize: 0,
                    unit:'سفارش'
                },{
                    data: data2,
                    points: { show: true,radius: 3 },
                    color: '#F82E66',
                    unit:'سفارش'
                }];
            }
            else if($("input[name='graph[]'][value='income']").prop("checked")){
                var data = [{
                    data: data1,
                    lines: {
                        fill: 0.2,
                        lineWidth: 0,
                    },
                    color: ['#BAD9F5'],
                    unit:'تومان'
                }, {
                    data: data1,
                    points: {
                        show: true,
                        fill: true,
                        radius: 4,
                        fillColor: "#9ACAE6",
                        lineWidth: 2
                    },
                    color: '#9ACAE6',
                    shadowSize: 1,
                    unit:'تومان'
                }, {
                    data: data1,
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 3
                    },
                    color: '#9ACAE6',
                    shadowSize: 0,
                    unit:'تومان'
                }];
            }
            else if($("input[name='graph[]'][value='orders']").prop("checked")){
                var data = [{
                    data: data2,
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 2
                    },
                    color: '#f791ac',
                    shadowSize: 0,
                    unit:'سفارش'
                },{
                    data: data2,
                    points: { show: true,radius: 3 },
                    color: '#F82E66',
                    unit:'سفارش'
                }];
            }else {
                var data = [{}];
            }
            var $chart_style1 = $.plot($(".chart_style1"),data,option);
            var plot_width_each_dot = $chart_style1.width() / 10;  
            var plot_scroll_x = (data1.length - 10) * plot_width_each_dot;
            $chart_style1.pan({left:plot_scroll_x,top:0});
        });

    });//dom ready
    
    function showChartTooltip(x, y, xValue, yValue,text) {
        //yValue = number_format(yValue) + ' تومان';
        $('<div class="tooltip_style1 rtl tright">' + text + '<\/div>').css({
            'position': 'absolute',
            'z-index':100,
            'display': 'none',
            'top': y - 40,
            'left': x - 40,
            'border': '0px solid #ccc',
            'padding': '2px 6px',
            'background-color': 'rgba(0,0,0,.5)',
            'color': '#fff',
            'border-radius': '2px',
        }).appendTo("body").show(0);
    }
</script>
@endsection