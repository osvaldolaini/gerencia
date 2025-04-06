import axios from 'axios';
window.axios = axios;
import Inputmask from 'inputmask';
import Alpine from 'alpinejs'
import mask from '@alpinejs/mask'

Alpine.plugin(mask)
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//Graficos
import Chart from 'chart.js/auto';
window.Chart = Chart;