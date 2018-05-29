
class Controller extends Entity.UniqueItem {
    blade: string = lowerCapital(this.name)
    name: string = snake2camel(upperCapital(this.name)) + 'Controller'
    nameSpace: string
    path: string
    middleware = new Entity.UniqueList<Middleware>(Middleware)
    
}
