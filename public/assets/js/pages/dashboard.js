
$(function(){
    $.get('http://127.0.0.1:8000/api/chart/chart-formulaires' , {random_id:Math.random()} , function (data){
        let labels = data.labels;
        let datasetItems = [];

        let obj = data.dataset;
        $.each(obj , function(i , text){
            datasetItems.push({
                name: obj[i].name,
		        data: obj[i].values
            });
        });

        var optionsProfileVisit = {
            annotations: {
                position: 'back'
            },
            dataLabels: {
                enabled:true
            },
            chart: {
                type: 'bar',
                height: 300
            },
            fill: {
                opacity:1
            },
            plotOptions: {
            },
            series:datasetItems ,
            colors: '#435ebe',
            xaxis: {
                categories: labels,
            },
        }




        var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);


        chartProfileVisit.render();
    })
});


