
class Project extends Entity.UniqueItem {
    version = 3.0
    nameSpace = 'App'
    migrationPath = 'database\\migrations'
    modelNameSpace = 'App\\Model'
    modelPath = 'app\\Model'
    factoryPath = 'database\\factories'
    controllerNameSpace = 'App\\Http\\Controllers'
    controllerPath = 'app\\Http\\Controllers'
    formPath = 'resources\\views'
    table = new Entity.UniqueList<Table>(Table)

    change(key: string, value: string) {
        if ('nameSpace' == key) {
            this.changeNameSpace(value)
        }
        this[key] = value

        this.table.list.forEach(table => table.from(this))
    }

    changeNameSpace(nameSpace: string) {
        let ns = this.nameSpace
        for (const key of Object.keys(this)) {
            let item = this[key]
            if ("string" == typeof item) {
                if (this[key] == ns) {
                    this[key] = nameSpace
                    continue
                }
                let re = new RegExp('^' + ns + '\\\\')
                this[key] = item.replace(re, nameSpace + '\\')
            }
        }
    }

}
