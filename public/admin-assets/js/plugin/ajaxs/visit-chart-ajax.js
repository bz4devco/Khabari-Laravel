fetch("/admin/visits-data")
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        var ctx = document.getElementById("visits").getContext("2d");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: data.labels.map((item) => item),
                datasets: [
                    {
                        label: "تعداد بازدید",
                        data: data.lastVisitsOnTenDays.map((item) => item),
                        borderColor: "rgba(75, 192, 192, 1)",
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: "بازدید وبسایت در 10 روز اخیر",
                        font: {
                            family: "IRANSans",
                            size: 18,
                        },
                    },
                },
            },
        });
    });

fetch("/admin/reports-data")
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        var ctx = document.getElementById("reports").getContext("2d");
        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: data.labels.map((item) => item),
                datasets: [
                    {
                        label: "تعداد خبر",
                        data: data.lastReportsOnTenDays.map((item) => item),
                        borderColor: "rgba(176, 47, 196, 1)",
                        backgroundColor: "rgba(176, 47, 196, 0.5)",
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: "تعداد انتشار خبر در 10 روز اخیر",
                        font: {
                            family: "IRANSans",
                            size: 18,
                        },
                    },
                },
            },
        });
    });
