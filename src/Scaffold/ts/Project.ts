/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
/// <reference path="./Table.ts" />

class Project extends Entity.UniqueItem {
    version = 3.0
    nameSpace = 'App'
    modelNameSpace = 'App\\Model'
    controllerNameSpace = 'App\\Http\\Controllers'
    table = new Entity.UniqueList<Table>(Table)

    change(key: string, value: string) {
        if ('nameSpace' == key) {
            this.changeNameSpace(value)
        }
        this[key] = value

        this.table.list.forEach(table => table.from(this))
    }

    changeNameSpace(nameSpace: string) {
        for (const key of Object.keys(this)) {
            let item = this[key]
            if ("string" == typeof item) {
                if (this[key] == this.nameSpace) {
                    this[key] = nameSpace
                    continue
                }
                let re = new RegExp('^' + this.nameSpace + '\\\\')
                this[key] = item.replace(re, nameSpace + '\\')
            }
        }
    }

}
