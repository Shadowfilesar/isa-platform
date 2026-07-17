export function uuid() {
    if (
        typeof globalThis.crypto !== "undefined" &&
        typeof globalThis.crypto.randomUUID === "function"
    ) {
        return globalThis.crypto.randomUUID();
    }

    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, (char) => {
        const random = Math.floor(Math.random() * 16);
        const value = char === "x" ? random : (random & 0x3) | 0x8;

        return value.toString(16);
    });
}

export function debounce(fn, delay) {
    let timer = null;

    return function debounced(...args) {
        const context = this;

        clearTimeout(timer);

        timer = setTimeout(() => {
            fn.apply(context, args);
        }, delay);
    };
}

export function clamp(value, min, max) {
    return Math.min(Math.max(value, min), max);
}

export function distance(x1, y1, x2, y2) {
    const dx = x2 - x1;
    const dy = y2 - y1;

    return Math.hypot(dx, dy);
}

export function getMousePosition(event, container) {
    const rect = container.getBoundingClientRect();

    return {
        x: event.clientX - rect.left + container.scrollLeft,
        y: event.clientY - rect.top + container.scrollTop,
    };
}