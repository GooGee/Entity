<script type="text/x-template" id="tttEntry">
    <table class="table">
        <caption><h3>Entity</h3></caption>
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
        <tr v-for="entry in project.entry.list">
            <td>
                <div class="btn-group">
                    <span v-on:click="project.entry.moveUp(entry)" class="btn btn-info">↑</span>
                    <span v-on:click="project.entry.moveDown(entry)" class="btn btn-info">↓</span>
                </div>
                <span v-on:click="show(entry)" class="btn btn-primary">Show</span>
                <span v-on:click="remove(entry)" class="btn btn-danger">X</span>
            </td>
            <td><input v-model="entry.table.name" class="form-control" type="text"></td>
            <td><input v-model="entry.factory.name" class="form-control" type="text"></td>
            <td><input v-model="entry.model.name" class="form-control" type="text"></td>
            <td><input v-model="entry.controller.name" class="form-control" type="text"></td>
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

    Vue.component('ccc-entry', {
        template: '#tttEntry',
        props: ['project'],
        methods: {
            add: function () {
                let name = prompt('Please enter the Entity name');
                if (name) {
                    let entry = this.project.entry.create(name);
                    try {
                        entry.from(this.project);
                        this.project.entry.add(entry);
                    } catch (exc) {
                        alert(exc);
                    }
                }
            },
            show: function (entry) {
                this.$emit('show', entry);
            },
            remove: function (entry) {
                if (confirm('Are you sure?')) {
                    this.project.entry.remove(entry);
                }
            }
        }
    });

</script>
