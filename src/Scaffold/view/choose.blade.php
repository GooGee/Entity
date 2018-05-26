<script type="text/x-template" id="tttChoose">

    <ccc-dialogue :dialogue="dialogue" v-on:hide="no">
        <template slot="title"><span v-text="data.message"></span></template>
        <template slot="body">
            <select v-model="data.item" class="form-control">
                <option v-for="item in data.array" v-bind:value="item" v-text="display(item)"></option>
            </select>
        </template>
        <template slot="footer">
            <span v-on:click="yes" class="btn btn-success">V</span>
            <span v-on:click="no" class="btn btn-danger">X</span>
        </template>
    </ccc-dialogue>

</script>


<script type="text/javascript">

    Vue.component('ccc-choose', {
        template: '#tttChoose',
        props: ['data'],
        data: function () {
            return {
                dialogue: {
                    canClose: true,
                    footer: true
                }
            };
        },
        methods: {
            display: function (item) {
                if (this.data.display) {
                    return item[this.data.display];
                }
                return item;
            },
            yes: function () {
                if (this.data.item) {
                    if (this.data.callback) {
                        this.data.callback(true, this.data.item);
                    }
                    this.$emit('close');
                }
            },
            no: function () {
                if (this.data.callback) {
                    this.data.callback(false);
                }
                this.$emit('close');
            }
        }
    });

</script>
