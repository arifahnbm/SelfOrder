import ApexCharts from "apexcharts";

const chartCustomer = () => {
  const options = {
    series: [{
      name: "Customers",
      data: typeof customerChartData !== 'undefined' ? customerChartData : [],
    }],
    colors: ["#dbeafe"], 
    chart: {
      fontFamily: "Outfit, sans-serif",
      type: "bar",
      height: 180,
      toolbar: { show: false },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "39%",
        borderRadius: 5,
        borderRadiusApplication: "end",
      },
    },
    dataLabels: { enabled: false },
    stroke: {
      show: true,
      width: 4,
      colors: ["transparent"],
    },
    xaxis: {
      categories: [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
      ],
      axisBorder: { show: false },
      axisTicks: { show: false },
    },
    legend: {
      show: true,
      position: "top",
      horizontalAlign: "left",
      fontFamily: "Outfit",
      markers: { radius: 99 },
    },
    yaxis: { title: false },
    grid: {
      yaxis: { lines: { show: true } },
    },
    fill: { opacity: 1 },
    tooltip: {
      x: { show: false },
      y: {
        formatter: function (val) {
          return val;
        },
      },
    },
  };

  const chartEl = document.querySelector("#chartCustomer");

  if (chartEl) {
    const chart = new ApexCharts(chartEl, options);
    chart.render();
  }
};

export default chartCustomer;
