$(function(){
var ctx = document.getElementById('myChart').getContext('2d');
var base_url = window.location.origin;
retrieveData();

$("form.frm_users").submit(function(e){
    if ($.trim($('input.input_fname').val()) == "" || $.trim($('input.input_fname').val()) == null) {
        $('input.input_fname').attr('disabled', true);
    }

    if ($.trim($('input.input_lname').val()) == "" || $.trim($('input.input_lname').val()) == null) {
        $('input.input_lname').attr('disabled', true);
    }

    if ($.trim($('input.input_email').val()) == "" || $.trim($('input.input_email').val()) == null) {
        $('input.input_email').attr('disabled', true);
    }
});

function retrieveData() {
    // get url parameters
    var params = new window.URLSearchParams(window.location.search);
    var page = params.get('page') == null || params.get('page') == '' ? 1 : params.get('page');
    var firstname = params.get('firstname') == null || params.get('firstname') == '' ? '' : params.get('firstname');
    var surname = params.get('surname') == null || params.get('surname') == '' ? '' : params.get('surname');
    var email = params.get('email') == null || params.get('email') == '' ? '' : params.get('email');

    $.ajax({
            type:"post",
            url: base_url+"/index.php/home/ajaxRequest",
            data:{ page: page, firstname: firstname, surname: surname, email:email},
            dataType:'json',
            success:function(response){
                $.each(response.users, function(index, element) {
                    $("<div class='list_row'><div class='list_field'>"+element.id+"</div><div class='list_field'>"+element.firstname+"</div><div class='list_field'>"+element.surname+"</div><div class='list_field'> - PRIVACY - </div><div class='list_field'>"+element.gender+"</div><div class='list_field'>"+element.joined_date+"</div></div>").appendTo(".user_list");
                });

                // chart
                var label_year = [];
                var data_total = [];
                $.each(response.chart, function(index, element) {
                    label_year.push(element.year);
                    data_total.push(element.total);
                });

                var chart_config = {
                    type: 'line',
                    data: {
                        labels: label_year,
                        datasets: [{
                            label: 'Total of User Registration (year)',
                            data: data_total,
                            borderColor: "rgb(121,189,67)"
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'User Registration Chart'
                        }
                    }
                }
                var myLineChart = new Chart(ctx, chart_config);

                document.getElementById("myChart").onclick = function (evt) {
                    // => activePoints is an array of points on the canvas that are at the same position as the click event.
                    var activePoint = myLineChart.lastActive[0];
                    if (activePoint !== undefined) {
                        var index = activePoint._index;
                        var datasetIndex = activePoint._datasetIndex;
                        var title = chart_config.data.labels[index];
                        var dataValue = chart_config.data.datasets[datasetIndex].data[index];

                        $.ajax({
                            type:"post",
                            url: base_url+"/index.php/home/ajaxCanvasRequest",
                            data:{ year: title},
                            dataType:'json',
                            success:function(resp){
                                console.log(resp);
                                var content = "";
                                content += "<div class='chart_promp'>";
                                    content += "<div class='chart_promp_title' >Year "+title+"</div>";
                                    content += "<input type='button' class='btn_close' value='X'>";
                                    content += "<div class='chart_promp_table'>";
                                        //content += "<div class='chart_promp_row'>";
                                            content += "<div class='chart_promp_cell'><b>Month</b></div>";
                                            content += "<div class='chart_promp_cell'><b>Total</b></div>";
                                        //content += "</div>";
                                    $.each(resp.mon_chart, function(index, element) {
                                        //content += "<div class='chart_promp_row'>";
                                            content += "<div class='chart_promp_cell'>"+element.month+"</div>";
                                            content += "<div class='chart_promp_cell'>"+element.total+"</div>";
                                    // content += "</div>";
                                    });
                                    content += "</div>";
                                content += "</div>";

                                $("div.container").prepend(content);
                            }
                        });
                    }

                };

                $("div.container .pagination").append(response.links);
            },
            error: function() {
                alert("Error!");
            }
    });
}

    $(document).on("click",".btn_close",function(e) {
        $(".chart_promp").remove();
    });
});