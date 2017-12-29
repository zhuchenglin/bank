<template>
    <div>
        <el-table v-loading="load_user_list"
                     element-loading-text="拼命加载中"
                     element-loading-spinner="el-icon-loading"
                     :style=" $parent.isCollapse ? 'width:90%;' : 'width:80%;'"
                     style="margin:auto;display: inline-block"
                     :data="account_record">
            <el-table-column
                    label="账户"
                    width="200">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.origin_acc }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="100">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.receive_acc ? '转账' : !scope.row.receive_acc && scope.row.status==0 ? '存款' : !scope.row.receive_acc && scope.row.status==0 ? '取款' : ''}}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="金额/元"
                    width="250">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.money }}</span>
                </template>
            </el-table-column>
            <el-table-column v-if="$route.name=='all/transfer/record' || $route.name=='account/transfer/record'"
                    label="目标账户"
                    width="150">
                <template slot-scope="scope">
                    <span v-if="scope.row.receive_acc" style="margin-left: 10px">{{ scope.row.receive_acc }}</span>
                    <span v-if="!scope.row.receive_acc" style="margin-left: 10px"></span>
                </template>
            </el-table-column>
            <el-table-column
                    label="时间"
                    >
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.create_time | date('yyyy-MM-dd hh:mm:ss') }}</span>
                </template>
            </el-table-column>
        </el-table>
        <div style="text-align: center" v-if="account_record_num>0">
            <el-pagination
                    layout="prev, pager, next"
                    :page-size="num"
                    :total="account_record_num"
                    @current-change="page_change()">
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
                load_user_list:false,
                type:1,
                num:20,
                page:0,
                account_id:0,
                account_record:[],
                account_record_num:0,
            }
        },
        components: {

        },
        computed: {},
        methods: {
            get_account_record(){
                let data = {
                    type:this.type,
                    num:this.num,
                    page:this.page,
                    account:this.account
                }
                this.load_user_list = true;
                this.send_request('post','/admin/account_record/list',function (response,self) {
                    self.load_user_list = false;
                    if(response.data.code==0){
                        self.account_record = response.data.result.num;
                        self.account_record_num = response.data.result.count;
                    }else {
                        self.show_message("获取失败，请稍后再试");
                    }
                },data)
            },
            page_change(page){
                this.page = page;
                this.get_account_record();
            }
        },
        mounted() {
            if(this.$route.name=='all/access/record'){
                this.type = 2;
            }else if(this.$route.name=='account/access/record'){
                this.type = 2;
                this.account_id = this.$route.params.account_id;
            }else if(this.$route.name=='all/transfer/record'){
                this.type = 1;
            }else if(this.$route.name=='account/transfer/record'){
                this.type = 1;
                this.account_id = this.$route.params.account_id;
            }
            this.get_account_record();
        },
    }
</script>