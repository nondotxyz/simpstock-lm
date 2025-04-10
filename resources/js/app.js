import "../css/app.css";

import { createApp, h } from "vue";

import Highcharts from "highcharts";
import HighchartsVue from "highcharts-vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

Highcharts.setOptions({
    chart: {
        backgroundColor: "#27272a", // bg-neutral-800
        style: {
            fontFamily: "Kumbh Sans, sans-serif",
        },
    },
    colors: ["#56F57B", "#3DD0F5", "#1735B0", "#BFBFBF"],
    title: {
        style: {
            color: "#ffffff",
        },
    },
    xAxis: {
        lineColor: "#404040",
        tickColor: "#404040",
        lineWidth: 2,
        labels: {
            style: {
                color: "#ffffff",
                fontFamily: "Kumbh Sans, sans-serif",
            },
        },
        title: {
            style: {
                color: "#ffffff",
                fontFamily: "Kumbh Sans, sans-serif",
            },
        },
    },
    yAxis: {
        lineColor: "#404040",
        lineWidth: 2,
        gridLineColor: "#404040",
        gridLineWidth: 1,
        labels: {
            style: {
                color: "#ffffff",
                fontFamily: "Kumbh Sans, sans-serif",
            },
        },
        title: {
            style: {
                color: "#ffffff",
                fontFamily: "Kumbh Sans, sans-serif",
            },
        },
    },
    legend: {
        itemStyle: {
            color: "#ffffff",
            fontFamily: "Kumbh Sans, sans-serif",
        },
    },
});

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(HighchartsVue)
            .mount(el);
    },
    progress: {
        color: "#f3f3f3",
    },
});
