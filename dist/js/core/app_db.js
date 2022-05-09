class AppDB {
    #KEY = '$M4#@mmpg26p(h?';
    #instance;

    static createInstance = async (instanceName = 'default_db') => {
        const app_db = new AppDB();

        app_db.#instance = localforage.createInstance({
            name: instanceName
        });

        app_db.get = async (key) => {
            const result = await app_db.#instance.getItem(key);

            return Promise.resolve(result);
        }

        app_db.save = async ({key, value} = {}) => {
            const n = await app_db.#instance.setItem(key, value);
            return Promise.resolve(n);
        }

        app_db.delete = async (key) => {
            const n = await app_db.#instance.removeItem(key);
            return Promise.resolve(n);
        }

        return Promise.resolve(app_db);
    }
}