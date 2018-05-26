
class Project extends Entity.UniqueItem {
    version = 2.0
    nameSpace = 'App'
    migrationPath = 'database\\migrations'
    modelNameSpace = 'App\\Model'
    modelPath = 'app\\Model'
    factoryPath = 'database\\factories'
    controllerNameSpace = 'App\\Http\\Controllers'
    controllerPath = 'app\\Http\\Controllers'
    formPath = 'resources\\views'
    entry = new Entity.UniqueList<Entry>(Entry)

    change(key: string, value: string) {
        if ('nameSpace' == key) {
            this.changeNameSpace(value)
        }
        this[key] = value

        this.entry.list.forEach(entry => entry.from(this))
    }

    changeNameSpace(nameSpace: string) {
        let ns = this.nameSpace
        for (let key in this) {
            if (this.hasOwnProperty(key)) {
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

}
