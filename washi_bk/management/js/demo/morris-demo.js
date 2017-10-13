$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2012-1',
            ยอดเงิน: 2666
            
        }, {
            period: '2012-2',
            ยอดเงิน: 2778
            
        }, {
            period: '2012-3',
            ยอดเงิน: 4912
            
        }, {
            period: '2012-4',
            ยอดเงิน: 3767
           
        }, {
            period: '2012-5',
            ยอดเงิน: 6810
            
        }, {
            period: '2012-6',
            ยอดเงิน: 5670
            
        }, {
            period: '2012-7',
            ยอดเงิน: 4820
           
        }, {
            period: '2012-8',
            ยอดเงิน: 15073
            
        }, {
            period: '2012-9',
            ยอดเงิน: 10687
           
        }, {
            period: '2012-10',
            ยอดเงิน: 8432
        }, {
            period: '2012-11',
            ยอดเงิน: 8000
        }, {
            period: '2012-12',
            ยอดเงิน: 7213           
        }],
        xkey: 'period',
        ykeys: ['ยอดเงิน'],
        labels: ['ยอดเงิน'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 50,
            b: 40
        }, {
            y: '2012',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

    Morris.Line({
        element: 'morris-line-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 50,
            b: 40
        }, {
            y: '2012',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

});
