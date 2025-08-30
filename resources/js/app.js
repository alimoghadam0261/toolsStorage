import './bootstrap';
import 'bootstrap';
import Chart from 'chart.js/auto';
import '@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css';

// جاوااسکریپت رو باید دستی لود کنیم
import '/node_modules/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js';

// حالا jalaliDatepicker در window موجود میشه
document.addEventListener("DOMContentLoaded", function () {
    window.jalaliDatepicker.startWatch();
});


//chart js dashboard admin
window.Chart = Chart;


