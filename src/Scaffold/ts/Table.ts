
class Table extends Entity.UniqueItem {
    field = new Entity.UniqueList<Field>(Field)
    index = new Entity.UniqueList<Index>(Index)
    factory = new Factory(this.name, this)
    model = new Model(this.name, this)
    controller = new Controller(this.name)
    form = new Form(this.name, this.model)

    constructor(name: string) {
        super(name)
        this.name = camel2snake(lowerCapital(this.name))
        this.field.onAfterNameChange(this.handelNameChange)
    }

    from(project: Project) {
        this.model.nameSpace = project.modelNameSpace;
        this.controller.nameSpace = project.controllerNameSpace;
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
