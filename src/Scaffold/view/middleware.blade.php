<script type="text/x-template" id="tttMiddleware">
    <table class="table">
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
                    <span v-on:click="controller.middleware.moveUp(middleware)" class="btn btn-info">↑</span>
                    <span v-on:click="controller.middleware.moveDown(middleware)" class="btn btn-info">↓</span>
                </div>
                <span v-on:click="remove(middleware)" class="btn btn-danger">X</span>
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
                        <input v-model="middleware.method[method]" type="checkbox">
                        <span v-text="method"></span>
                    </label>
                </span>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <span v-on:click="add" class="btn btn-primary">+</span>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-middleware', {
        template: '#tttMiddleware',
        props: ['controller'],
        data: function () {
            return {
                methodArray: ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']
            };
        },
        methods: {
            add: function () {
                let name = prompt('Please enter the Middleware name');
                if (name) {
                    let middleware = this.controller.middleware.create(name);
                    this.controller.middleware.add(middleware);
                }
            },
            remove: function (middleware) {
                if (confirm('Are you sure?')) {
                    this.controller.middleware.remove(middleware);
                }
            }
        }
    });

</script>
