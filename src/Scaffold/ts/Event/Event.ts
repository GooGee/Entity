
namespace Entity {

    export class Event<T> {
        protected listeners: Listener<T>[] = []

        on = (listener: Listener<T>) => {
            this.listeners.push(listener)
            return {
                off: () => this.off(listener)
            }
        }

        off = (listener: Listener<T>) => {
            let index = this.listeners.indexOf(listener)
            if (index > -1) this.listeners.splice(index, 1)
        }

        emit = (event: T) => {
            this.listeners.forEach((listener) => listener(event))
        }

    }

}
