import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();

import { Select, Input, initTE, Collapse } from "tw-elements";
initTE({ Select, Input, Collapse });
