const baseUrl = (path = '') => {
    let base_url = window.location.origin;

    while (path.substring(0, 1) == '/') {
        path = path.slice(0, 1);
    }

    return `${base_url}/${path}`;
}