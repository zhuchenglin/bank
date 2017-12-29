<template>
    <div>
        <el-table    v-loading="load_user_list"
                     element-loading-text="拼命加载中"
                     element-loading-spinner="el-icon-loading"
                :style=" $parent.isCollapse ? 'width:90%;' : 'width:80%;'"
                  style="margin:auto;display: inline-block"
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
                            @click="$router.push('/nav/account/user/index/'+scope.row.id)">账户详情</el-button>
                    <el-button
                            size="mini"
                            @click="en_disable(scope.row.id,scope.row.status)">{{scope.row.status==0 ? '禁用' : '启用'}}</el-button>
                    <el-button
                            size="mini"
                            type="danger"
                            @click="handleDelete(scope.row.id)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div style="text-align: center" v-if="total_num>0">
            <el-pagination
                    layout="prev, pager, next"
                    :page-size="num"
                    :total="total_num"
                    @current-change="change_page()">
            </el-pagination>
        </div>
    </div>
</template>

<style scoped>

</style>

<script scoped>

    export default {
        data(){
            return {
                users:[],
                no_data:false,
                user_id:0,
                can_operate:true,
                load_user_list:false,
                total_num:0,
                page:0,
                num:20
            }
        },
        components: {

        },
        computed: {},
        methods: {
            get_users(){
                this.load_user_list = true;
                this.send_request('post','/admin/user/list',function (response,self) {
                    self.load_user_list = false;
                    if(response.data.code==0){
                        self.users = response.data.result.result;
                        self.total_num = response.data.result.result_num
                    }else{
                        self.$message({
                            message:response.data.msg,
                            type: 'error'
                        });
                    }
                })
            },
            handleEdit(id,name,phone,ID_card){

            },
            en_disable(id,status){
                if(this.can_operate){
                    this.can_operate=false;
                    let stat;
                    if(status==0){
                        stat = 2;
                    }else{
                        stat = 0;
                    }
                    let data = {
                        user_id:id,
                        status:stat
                    }
                    this.send_request('post','/admin/user/en_disable',function (response,self) {
                        if(response.data.code==0){
                            self.show_message(response.data.msg,'success');
                            setTimeout(()=>{
                                    history.go(0);
                                },1000)
                        }else{
                            self.show_message(response.data.msg,'warning');
                            self.can_operate = true;
                        }
                    },data)
                }
            },
            handleDelete(id){
                let self = this;
                this.$confirm('确定要删除该用户吗?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    if(self.can_operate){
                        self.can_operate = false;
                        let data = {
                            user_id:id,
                            status:1
                        }
                        self.send_request('post','/admin/user/delete',function (response,self) {
                            if(response.data.code==0){
                                self.show_message(response.data.msg,'success');
                                setTimeout(()=>{
                                    history.go(0);
                                },1000)
                            }else{
                                self.show_message(response.data.msg,'warning');
                                self.can_operate = true;
                            }
                        },data)
                    }
                }).catch(() => {

                });
            },
            change_page(page){
                this.page = page;
                this.get_users();
            }

        },
        mounted() {
            this.get_users();
        },
    }
</script>