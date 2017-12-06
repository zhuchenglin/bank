<template>
    <div>
        <el-table :style=" $parent.isCollapse ? 'width:90%;margin: 0 auto' : 'width:80%;margin: 0 auto'"
                :data="users">
            <el-table-column
                    label="姓名"
                    width="80">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.name }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="账号"
                    width="150">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.account }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="身份证号"
                    width="250">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.ID_card }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="电话号"
                    width="150">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.phone }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="创建时间"
                    width="80">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.create_time }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="更新时间"
                    width="80">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.update_time }}</span>
                </template>
            </el-table-column>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button
                            size="mini"
                            @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button
                            size="mini"
                            type="danger"
                            @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<style scoped>

</style>

<script scoped>

    export default {
        data(){
            return {
                users:[],
                no_data:false
            }
        },
        components: {

        },
        computed: {},
        methods: {
            get_users(){
                this.send_request('post','/admin/user/list',function (response,self) {
                    if(response.data.code==0){
                        self.users = response.data.result;
                        if(self.users.length<0){

                        }
                    }else{

                    }
                })
            }
        },
        mounted() {
            this.get_users();
        },
    }
</script>