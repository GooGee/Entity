<script type="text/x-template" id="tttMiddleware">
    <table class="table table-striped table-bordered">
        <caption><h3>Middleware</h3></caption>
        <thead>
        <tr>
            <th width="150px"></th>
            <th style="width: 22%;">Name</th>
            <th style="width: 120px;">Type</th>
            <th>Method</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="middleware in controller.middleware.list">
            <td>
                <div class="btn-group">
                    <button v-on:click="controller.middleware.moveUp(middleware)" class="btn btn-info" type="button">↑</button>
                    <button v-on:click="controller.middleware.moveDown(middleware)" class="btn btn-info" type="button">↓</button>
                </div>
                <button v-on:click="remove(middleware)" class="btn btn-danger" type="button">X</button>
            </td>
            <td><input v-model="middleware.name" class="form-control" type="text"></td>
            <td>
                <select v-model="middleware.type" class="form-control">
                    <option value="all">All</option>
                    <option value="only">Only</option>
                    <option value="except">Except</option>
                </select>
            </td>
            <td>
                <span class="pull-left">
                    <label v-for="method in methodArray" class="mr">
                    <input v-model="middleware.method[method]" type="checkbox">@brace('method')
                    </label>
                </span>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <button v-on:click="add" class="btn btn-primary" type="button">+</button>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    const methodArray = ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'];

    Vue.component('ccc-middleware', {
        template: '#tttMiddleware',
        props: ['controller'],
        data: function () {
            return {
                methodArray: methodArray
            };
        },
        methods: {
            add: function () {
                let name = prompt('Please enter the Middleware name');
                if (isEmpty(name)) {
                    return;
                }
                this.controller.middleware.create(name);
            },
            remove: function (middleware) {
                if (confirm('Are you sure?')) {
                    this.controller.middleware.remove(middleware);
                }
            }
        }
    });

</script>
