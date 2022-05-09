class AppSession {
    #KEY = '@M}@0.J%tE8R&Lb';
    #instance;

    static createInstance = async () => {
        const app_session = new AppSession();

        app_session.#instance = await AppDB.createInstance('app-session');

        app_session.get = async (key) => {
            let result = await app_session.#instance.get(key);
            
            if(!result)
                return null;
    
            try {
                const bytes  = CryptoJS.AES.decrypt(result, app_session.#KEY);
                result = bytes.toString(CryptoJS.enc.Utf8);
            } catch (error) {}
    
            try {
                result = JSON.parse(result);
            } catch (error) {}
    
            return Promise.resolve(result);
        }

        app_session.set = async ({key, value} = {}) => {
            try {
                value = JSON.stringify(value);
            } catch (error) {}

            const encrypted = CryptoJS.AES.encrypt(value, app_session.#KEY).toString();
            const saved = await app_session.#instance.save({key: key, value: encrypted});

            return Promise.resolve(saved);
        }

        app_session.unset = async (key) => {

        }
        
        return Promise.resolve(app_session);
    }
}