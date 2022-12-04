export const isLoaded = element => element.getAttribute('data-loaded') === 'true';

export const markLoaded = (element) => {
    element.setAttribute('data-loaded', true);
}

export const preLoad = (element) => {
    if (element.getAttribute('data-placeholder-background')) {
        element.style.background = element.getAttribute('data-placeholder-background');
    }
}

export const onIntersection = (load, loaded) => (entries, observer) => {
    entries.forEach(entry => {
        if (entry.intersectionRatio > 0 || entry.isIntersecting) {
            observer.unobserve(entry.target);

            if (!isLoaded(entry.target)) {
                load(entry.target);
                markLoaded(entry.target);
                loaded(entry.target);
            }
        }
    });
};

export const getElements = (selector, root = document) => {
    if (selector instanceof Element) {
        return [selector]
    }

    if (selector instanceof NodeList) {
        return selector
    }

    return root.querySelectorAll(selector)
};