
class Controller extends Entity.UniqueItem {
    name: string = upperCapital(this.name) + 'Controller'
    blade: string = lowerCapital(this.name)
    nameSpace: string
    path: string
    middleware = new Entity.UniqueList<Middleware>(Middleware)
    
}
