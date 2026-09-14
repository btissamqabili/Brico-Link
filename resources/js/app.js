

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('error', (event) => {
	if (event.target instanceof HTMLImageElement) {
		event.target.hidden = true;
	}
}, true);

Alpine.start();
