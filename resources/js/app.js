import './bootstrap';
import 'flowbite';
import initSelect from '@preline/select';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import './flowbite-datepicker';

import.meta.glob(['../img/**']);

window.Alpine = Alpine;

Alpine.start();

const originalSetAttribute = Element.prototype.setAttribute;
Element.prototype.setAttribute = function (name, value) {
    if (name === 'aria-hidden' && value === 'true') {
        // console.warn("Se ha bloqueado la adición de aria-hidden='true'");
        return;
    }
    return originalSetAttribute.apply(this, arguments);
};
