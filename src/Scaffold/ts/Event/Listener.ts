
namespace Entity {

    export interface Listener<T> {
        (event: T): void
    }

}
