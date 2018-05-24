<script type="text/x-template" id="tttVariable">
    <table class="table table-striped table-bordered">
        <caption>
            <h3>Variable</h3>
        </caption>
        <thead>
        <tr>
            <th width="90px"></th>
            <th>Name</th>
            <th>Value</th>
            <th>Type</th>
            <th>Public</th>
            <th>Static</th>
            <th>Constant</th>
            <th>Ignore</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="variable in variable.list">
            <td>
                <button v-on:click="remove(variable)" class="btn btn-danger" type="button">X</button>
            </td>
            <td><input v-model="variable.name" class="form-control" type="text"></td>
            <td><input v-model="variable.value" class="form-control" type="text"></td>
            <td>
                <select v-model="variable.type" class="form-control">
                    <option value="json">JSON</option>
                    <option value="raw">Raw</option>
                    <option value="string">String</option>
                </select>
            </td>
            <td><input v-model="variable.public" class="form-control" type="checkbox"></td>
            <td><input v-model="variable.static" class="form-control" type="checkbox"></td>
            <td><input v-model="variable.constant" class="form-control" type="checkbox"></td>
            <td><input v-model="variable.ignore" class="form-control" type="checkbox"></td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-variable', {
        template: '#tttVariable',
        props: ['variable'],
        methods: {
            add: function () {
                let name = prompt('Please enter the Variable name');
                if (isEmpty(name)) {
                    return;
                }
                this.variable.create(name, '');
            },
            remove: function (name) {
                if (confirm('Are you sure?')) {
                    this.variable.remove(name);
                }
            }
        }
    });

</script>
