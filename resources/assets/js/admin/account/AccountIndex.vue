<template>
    <div>
        <el-table    v-loading="load_account_list"
                     element-loading-text="拼命加载中"
                     element-loading-spinner="el-icon-loading"
                     :style=" $parent.isCollapse ? 'width:90%;' : 'width:80%;'"
                     style="margin:auto;display: inline-block"
                     :data="accounts">
            <el-table-column
                    label="账号"
                    width="180">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.account }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="余额"
                    width="100">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.rest_money }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="创建时间"
                    width="180">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.create_time | date('yyyy-MM-dd hh:mm') }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="所属人姓名"
                    width="150">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.name }}</span>
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

            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button
                            size="mini"
                            @click="en_disable(scope.row.id,scope.row.status)">{{scope.row.status==0 ? '冻结' : '解冻'}}</el-button>
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
                    :total="total_num">
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
                accounts:[],
                no_data:false,
//                user_id:0,
                account_id:0,
                can_operate:true,
                load_account_list:false,
                page:0,
                num:20,
                total_num:0,
            }
        },
        components: {

        },
        computed: {},
        methods: {
            get_accounts(){
                this.load_account_list = true;
                let data = {
                    page:this.page,
                    num:this.num,
                }
                this.send_request('post','/admin/account/list',function (response,self) {
                    self.load_account_list = false;
                    if(response.data.code==0){
                        self.accounts = response.data.result.account;
                        self.total_num = response.data.result.account_num;
                    }else{
                        self.$message({
                            message:response.data.msg,
                            type: 'error'
                        });
                    }
                },data)
            },
            handleEdit(id,name,phone,ID_card){

            },
            en_disable(id,status){
                if(this.can_operate){
                    this.can_operate=false;
                    let stat;
                    if(status==0){
                        stat = 1;
                    }else{
                        stat = 0;
                    }
                    let data = {
                        account_id:id,
                        status:stat
                    }
                    this.send_request('post','/admin/account/en_disable',function (response,self) {
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
                this.$confirm('确定要删除该账户吗?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    if(self.can_operate){
                        self.can_operate = false;
                        let data = {
                            account_id:id,
                            status:2
                        }
                        self.send_request('post','/admin/account/delete',function (response,self) {
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
            }

        },
        mounted() {
            this.get_accounts();
        },
    }
</script>