
namespace Entity {

    export class Item {
        [key: string]: any
        protected static ignoreList = Array<string>()

        load(data: Item) {
            const ignoreList: string[] = Object.getPrototypeOf(this).constructor.ignoreList;
            for (const key of Object.keys(data)) {
                if (ignoreList.indexOf(key) >= 0) {
                    continue
                }
                let item = data[key]
                if (this[key] && this[key].load) {
                    this[key].load(item)
                    continue
                }
                this[key] = item
            }
        }

        toJSON(key: string) {
            let object: { [key: string]: any } = {}
            const ignoreList: string[] = Object.getPrototypeOf(this).constructor.ignoreList;
            for (const key of Object.keys(this)) {
                if (ignoreList.indexOf(key) >= 0) {
                    continue
                }
                object[key] = this[key]
            }
            return object
        }
    }

}
