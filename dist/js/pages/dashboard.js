const app = await Application.getInstance({authenticated: true});

$(document).ready(() => {
    app.hideLoader();
    app.activateNav(0);
});