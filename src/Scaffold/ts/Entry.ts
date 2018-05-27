
class Entry extends Entity.UniqueItem {
    name = upperCapital(snake2camel(this.name))
    table = new Table(this.name)
    factory = new Factory(this.name, this.table)
    model = new Model(this.name, this.table)
    controller = new Controller(this.name)
    form = new Form(this.name, this.model)

    from(project: Project) {
        this.table.path = project.migrationPath;
        this.model.nameSpace = project.modelNameSpace;
        this.model.path = project.modelPath;
        this.factory.path = project.factoryPath;
        this.controller.nameSpace = project.controllerNameSpace;
        this.controller.path = project.controllerPath;
        this.form.path = project.formPath;
    }

}
