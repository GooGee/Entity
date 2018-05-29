
class Table extends Entity.UniqueItem {
    path: string = ''
    name = camel2snake(lowerCapital(this.name))
    field = new Entity.UniqueList<Field>(Field)
    index = new Entity.UniqueList<Index>(Index)
    factory = new Factory(this.name, this)
    model = new Model(this.name, this)
    controller = new Controller(this.name)
    form = new Form(this.name, this.model)

    constructor(name: string) {
        super(name)
        this.field.onAfterNameChange(this.handelNameChange)
    }

    from(project: Project) {
        this.path = project.migrationPath;
        this.model.nameSpace = project.modelNameSpace;
        this.model.path = project.modelPath;
        this.factory.path = project.factoryPath;
        this.controller.nameSpace = project.controllerNameSpace;
        this.controller.path = project.controllerPath;
        this.form.path = project.formPath;
    }

    private handelNameChange = (event: Entity.NameChange) => {
        this.index.list.forEach(index => {
            index.field.list.every(field => {
                if (field.name == event.old) {
                    field.name = event.name
                    return false
                }
                return true
            })
        })
    }

}
