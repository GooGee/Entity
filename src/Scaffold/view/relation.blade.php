<script type="text/x-template" id="tttRelation">
    <table class="table">
        <caption>
            <h3>Relation</h3>
        </caption>
        <thead>
        <tr>
            <th width="50px"></th>
            <th>Function Name</th>
            <th>Type</th>
            <th>Model</th>
            <th>Pivot Table</th>
            <th>Foreign Key</th>
            <th>Other Key</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="relation in model.relation.list">
            <td>
                <span v-on:click="remove(relation)" class="btn btn-danger">X</span>
            </td>
            <td><input v-model="relation.name" class="form-control" type="text"></td>
            <td><select v-model="relation.type" class="form-control">
                    <option value="belongsTo">belongsTo</option>
                    <option value="belongsToMany">belongsToMany</option>
                    <option value="hasOne">hasOne</option>
                    <option value="hasMany">hasMany</option>
                </select></td>
            <td>
                <span v-on:click="selectModel(relation)" class="btn btn-default" v-text="relation.model"></span>
            </td>
            <td>
                <span v-on:click="selectPivot(relation)" class="btn btn-default" v-text="plus(relation.pivot)"></span>
            </td>
            <td>
                <span v-on:click="selectForeign(relation)" class="btn btn-default"
                      v-text="plus(relation.foreignKey)"></span>
            </td>
            <td>
                <span v-on:click="selectOther(relation)" class="btn btn-default"
                      v-text="plus(relation.otherKey)"></span>
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
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-relation', {
        template: '#tttRelation',
        props: ['model', 'project'],
        methods: {
            plus: function (key) {
                if (key) {
                    return key;
                }
                return '+';
            },
            add: function () {
                let relation = this.model.relation;
                let data = {
                    message: 'Select the Model',
                    display: 'name',
                    array: this.project.table.list,
                    callback: function (yes, table) {
                        if (yes) {
                            let rrr = relation.create(table.name, 'belongsTo');
                            try {
                                relation.add(rrr);
                            } catch (exc) {
                                alert(exc);
                            }
                        }
                    }
                };
                choose(data);
            },
            remove: function (relation) {
                if (confirm('Are you sure?')) {
                    this.model.relation.remove(relation);
                }
            },
            selectModel: function (relation) {
                let data = {
                    message: 'Select the Model',
                    display: 'name',
                    array: this.project.table.list,
                    callback: function (yes, table) {
                        if (yes) {
                            relation.model = table.model.name;
                        }
                    }
                };
                choose(data);
            },
            selectPivot: function (relation) {
                let data = {
                    message: 'Select the Pivot Table',
                    display: 'name',
                    array: this.project.table.list,
                    callback: function (yes, table) {
                        if (yes) {
                            relation.pivot = table.name;
                        }
                    }
                };
                choose(data);
            },
            selectForeign: function (relation) {
                let list = this.model.table.field.list;
                if (relation.pivot) {
                    let pivot = this.project.table.find(relation.pivot);
                    if (!pivot) {
                        alert('Unknown pivot table!');
                        return;
                    }
                    list = pivot.field.list;
                }
                let data = {
                    message: 'Select the Foreign Key',
                    display: 'name',
                    array: list,
                    callback: function (yes, field) {
                        if (yes) {
                            relation.foreignKey = field.name;
                        }
                    }
                };
                choose(data);
            },
            selectOther: function (relation) {
                if (!relation.pivot) {
                    alert('Please select a Pivot table first!');
                    return;
                }
                let pivot = this.project.table.find(relation.pivot);
                if (!pivot) {
                    alert('Unknown pivot table!');
                    return;
                }
                let data = {
                    message: 'Select the Other Key',
                    display: 'name',
                    array: pivot.field.list,
                    callback: function (yes, field) {
                        if (yes) {
                            relation.otherKey = field.name;
                        }
                    }
                };
                choose(data);
            }
        }
    });

</script>
