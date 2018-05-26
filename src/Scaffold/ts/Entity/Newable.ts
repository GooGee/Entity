
namespace Entity {

    export interface Newable<T> {
        new (...args: any[]): T
    }

}