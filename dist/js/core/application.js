class Application {
    #sessionKeyName = {
        theme: '_ESAp4oeq',
        authData: '_3mItAfAk'
    };

    static getInstance = async ({authenticated = false} = {}) => {
        const app = new Application();

        app.session = await AppSession.createInstance();

        if(authenticated) {
            const authData = await app.session.get(app.#sessionKeyName.authData);

            // if(!authData)
            //     return window.location.href = baseUrl('authentication');

            console.log('AUTHDATA', authData);
        }

        app.changeTheme = () => {
            return {
                darkMode: () => {
                    app.session.set({
                        key: app.#sessionKeyName.theme,
                        value: 'theme-dark'
                    }).then((res) => {
                        $('body').removeClass('theme-light');
                        $('body').addClass('theme-dark');
                    });
                },
    
                lightMode: () => {
                    app.session.set({
                        key: app.#sessionKeyName.theme,
                        value: 'theme-light'
                    }).then((res) => {
                        $('body').removeClass('theme-dark');
                        $('body').addClass('theme-light');
                    });
                }
            };
        }

        app.hideLoader = (func = undefined) => {
            const divPage = $('div.page');
            const loaderWrap = $('div.load-wrapper');
            const loaderStyle = $('style#loader-style');
        
            function hideComponent() {
                loaderWrap.fadeOut(() => {
                    loaderWrap.remove();
                    loaderStyle.remove();
    
                    if(typeof func == 'function')
                        func();
                });
            };
        
            if(divPage.hasClass('init')) {
                divPage.fadeIn('slow', () => {
                    divPage.removeClass('init');
                    hideComponent();
                });
            } 
        }

        app.showLoader = (func = undefined) => {
            const loaderComponent = '<div class="load-wrapper" style="display:none"><div class="spinner"><div class="right-side"><div class="bar"></div></div><div class="left-side"><div class="bar"></div></div></div></div><style id="loader-style">body{overflow:hidden!important}div.page.init{display:none}.load-wrapper{position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:9999;background-color:rgba(30,41,59,.75)}*{box-sizing:border-box}.spinner{width:75px;height:75px;position:absolute;top:0;left:0;right:0;bottom:0;margin:auto;-webkit-animation:rotate-all 1s linear infinite}.left-side,.right-side{width:50%;height:100%;position:absolute;top:0;overflow:hidden}.left-side{left:0}.right-side{right:0}.bar{width:100%;height:100%;border-radius:100px 0 0 100px;border:5px solid #fff;position:relative}.bar:after{content:"";width:5px;height:5px;display:block;background:#fff;position:absolute;border-radius:5px}.right-side .bar{border-radius:0 200px 200px 0;border-left:none;transform:rotate(-10deg);transform-origin:left center;animation:rotate-right .75s linear infinite alternate}.right-side .bar:after{bottom:-5px;left:-2.5px}.left-side .bar{border-right:none;transform:rotate(10deg);transform-origin:right center;animation:rotate-left .75s linear infinite alternate}.left-side .bar:after{bottom:-5px;right:-2.5px}@keyframes rotate-left{to{transform:rotate(30deg)}from{transform:rotate(175deg)}}@keyframes rotate-right{from{transform:rotate(-175deg)}to{transform:rotate(-30deg)}}@keyframes rotate-all{from{transform:rotate(0)}to{transform:rotate(-360deg)}}</style>';
    
            $('body').append(loaderComponent);
            const loaderWrap = $('div.load-wrapper');
            loaderWrap.fadeIn('fast', () => {
                if(typeof func == 'function')
                    func();
            });
        }

        // set navbar active
        app.activateNav = index => {
            let navbarNav = $('ul.navbar-nav');
            navbarNav = navbarNav.children();

            try {
                const navItem = $(navbarNav[index]);
                navItem.addClass('active');
            } catch (error) {}
        };

        // get curent theme
        app.session.get(app.#sessionKeyName.theme).then(res => {
            if(!res)
                res = 'theme-light';

            switch (res) {
                case 'theme-light':
                    $('body').removeClass('theme-dark');
                    break;
            
                case 'theme-dark':
                    $('body').removeClass('theme-light');
                    break;

                default:
                    return false;
            }

            $('body').addClass(res);
        });

        (function() {
            $('a.change-theme').click((el, a) => {
                if(el.currentTarget.dataset.value == 'theme-dark')
                    return app.changeTheme().darkMode();
    
                return app.changeTheme().lightMode();
            });

            $(document).ready(() => {

            });
        }());

        return Promise.resolve(app);
    }
}