<script type="text/x-template" id="tttTable">
    <table class="table">
        <caption><h3>Table</h3></caption>
        <thead>
        <tr>
            <th width="200px"></th>
            <th>Table</th>
            <th>Factory</th>
            <th>Model</th>
            <th>Controller</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="table in project.table.list">
            <td>
                <div class="btn-group">
                    <span v-on:click="project.table.moveUp(table)" class="btn btn-info">↑</span>
                    <span v-on:click="project.table.moveDown(table)" class="btn btn-info">↓</span>
                </div>
                <span v-on:click="show(table)" class="btn btn-primary">Show</span>
                <span v-on:click="remove(table)" class="btn btn-danger">X</span>
            </td>
            <td><input v-model="table.name" class="form-control" type="text"></td>
            <td><input v-model="table.factory.name" class="form-control" type="text"></td>
            <td><input v-model="table.model.name" class="form-control" type="text"></td>
            <td><input v-model="table.controller.name" class="form-control" type="text"></td>
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
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-table', {
        template: '#tttTable',
        props: ['project'],
        methods: {
            add: function () {
                let name = prompt('Please enter the table name');
                if (name) {
                    let table = this.project.table.create(name);
                    try {
                        table.from(this.project);
                        this.project.table.add(table);
                    } catch (exc) {
                        alert(exc);
                    }
                }
            },
            show: function (table) {
                this.$emit('show', table);
            },
            remove: function (table) {
                if (confirm('Are you sure?')) {
                    this.project.table.remove(table);
                }
            }
        }
    });

</script>
