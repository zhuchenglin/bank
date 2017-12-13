<template>
    <el-select clearable v-model="id_copy" @change="value_change" v-loading="loading" placeholder="请选择卡号">
        <el-option
            v-for="item in lists"
            :label="item.account"
            :value="item.id">
        </el-option>
    </el-select>
</template>
<script>
    export default {
        data: function () {
            return {
                id_copy: "",
                lists: [],
                loading: false
            }
        },
        props: {
            id: {
                type: Number
            }
        },
        watch: {
            id: function (now) {
                if (this.id) {
                    this.id_copy = this.id
                }
            }
        },
        methods: {
            get_lists: function () {
                this.loading = true
                axios.get("/user/info/codenum").then(response =>{

                    this.loading = false
                    this.lists = response.data.result
                })
            },
            value_change: function () {
                let value = this.id_copy

                if (!value) {
                    this.$emit("change", null)
                    return
                }
                let lists = this.lists
                for (let i = 0; i < lists.length; i++) {
                    if (lists[i].id == value) {
                        this.$emit("change", lists[i])
                        break
                    }
                }
            }
        },
        mounted: function () {
            this.get_lists()
            if (this.id) {
                this.id_copy = this.id
            }
        }
    }
</script>