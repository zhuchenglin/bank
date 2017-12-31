<template>
    <div>
        <div class="gm-breadcrumb">
            <!--<i class="ion-ios-home gm-home"></i>-->
            <!-- <el-button type="text" class="gm-back" @click="$router.go(-1)"><i class="el-icon-arrow-left"></i></el-button> -->
            <el-breadcrumb separator="/">
                <el-breadcrumb-item to="/business/deopsit">个人信息</el-breadcrumb-item>
                <el-breadcrumb-item to="/business/deopsit">个人卡号</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
         <el-table
            :data="card_list"
            style="width: 100%"
            v-loading="tableLoading">
            <el-table-column
            type="index"
            width="50">
            </el-table-column>
            <el-table-column
                label="卡号"
                >
                 <template slot-scope="scope">
                    <div @click="click_account(scope.row)">
                        <el-tag  type="" >{{ scope.row.account }}</el-tag>
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                prop="rest_money"
                label="余额"
                width="180">
            </el-table-column>
            <el-table-column
                label="状态"
                width="180">
                <template slot-scope="scope">
                    <el-tag :type="tag[scope.row.status].name">{{tag[scope.row.status].status}}</el-tag>
                </template>
            </el-table-column>
        </el-table>


        <el-dialog title="操作记录" :visible.sync="dialogTableVisible">
            <el-select v-model="oprion_id" @change="select_change" clearable placeholder="请选择">
                <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
                </el-option>
            </el-select>
            <el-table 
                v-if="oprion_id!=0"
                :data="operList"
                border
                style="width: 100%;"
                v-loading="operLoading">
                <el-table-column
                type="index"
                width="40">
                </el-table-column>
                <el-table-column
                    label="金额"
                    >
                    <template  slot-scope="scope">{{ scope.row.money/100 }}</template>
                </el-table-column>

                <el-table-column
                    v-if="oprion_id == 3"
                    prop="account"
                    label="对方账户"
                    >
                </el-table-column>

                <el-table-column
                    prop="name"
                    label="操作人"
                    >
                </el-table-column>
                <el-table-column
                    label="操作时间"
                    >
                    <template  slot-scope="scope">{{ scope.row.create_time|date }}</template>
                </el-table-column>
            </el-table>
            <el-pagination 
                v-if="oprion_id!=0"
                style="padding: 1rem 0;"
                @current-change="current_change"
                @size-change="size_change"
                :page-sizes="[5, 10, 20, 50]"
                :page-size="page_size"
                layout="total, sizes, prev, pager, next, jumper"
                :total="paginate_total">
            </el-pagination>
        </el-dialog>

    </div>
</template>

<script scoped>

    export default {
        data() {
            return {
                card_list:[],
                tag:[
                        {
                            name:'success',
                            status:'正常',
                        },
                        {
                            name:'warning',
                            status:'冻结',
                        },
                ],
                dialogTableVisible :false,
                operList:[],
                tableLoading:false,
                operLoading : false,
                options: [{
                    value: '1',
                    label: '存款记录'
                }, {
                    value: '2',
                    label: '取款记录'
                }, {
                    value: '3',
                    label: '转账记录'
                }],
                oprion_id : 0,
                card_id : 0,


                page: 1,
                page_size: 5,
                paginate_total: 0
            }
        },
        methods: {
            get_list(){
                this.tableLoading = true
                axios.post('/user/cardlist').then(res =>{
                    console.log(res.data,this.tag)
                    this.card_list = res.data.result
                    this.tableLoading = false
                })
            },
            size_change: function (size) {
                this.page_size = size
                if(this.oprion_id == 1){
                    this.get_deposit_list()
                }else if(this.oprion_id == 2){
                    this.get_take_list()
                }else if(this.oprion_id ==3){
                    this.get_transfer_list()
                }
                // this.getList()
            },
            current_change: function (page) {
                this.page = page
                if(this.oprion_id == 1){
                    this.get_deposit_list()
                }else if(this.oprion_id == 2){
                    this.get_take_list()
                }else if(this.oprion_id ==3){
                    this.get_transfer_list()
                }
                // this.getList()
            },
            get_transfer_list(){
                this.operLoading = true
                var param = {
                    page_size: this.page_size, 
                    page: this.page,
                    account_id : this.card_id,
                };
                axios.post("/user/transferlist",param).then(res =>{
                    // console.log(res.data.result)
                    this.operList = res.data.result.data
                    this.paginate_total = res.data.result.total
                    this.operLoading = false
                }).catch(error => {
                    this.$message("网络错误")
                })
            },
            get_take_list(){
                this.operLoading = true
                var param = {
                    page_size: this.page_size, 
                    page: this.page,
                    account_id : this.card_id,
                };
                axios.post("/user/takemoneylist",param).then(res =>{
                    // console.log(res.data.result)
                    this.operList = res.data.result.data
                    this.paginate_total = res.data.result.total
                    this.operLoading = false
                }).catch(error => {
                    this.$message("网络错误")
                })
            },
            get_deposit_list(){
                this.operLoading = true
                var param = {
                    page_size: this.page_size, 
                    page: this.page,
                    account_id : this.card_id,
                };
                axios.post("/user/depositlist",param).then(res =>{
                    // console.log(res.data.result)
                    this.operList = res.data.result.data
                    this.paginate_total = res.data.result.total
                    this.operLoading = false
                }).catch(error => {
                    // console.log(error)
                    this.$message("网络错误")
                })
            },
            click_account(row){
                // console.log(row)
                this.card_id = row.id
                this.dialogTableVisible = true
            },
            select_change(value){
                console.log(value)
                this.page = 1
                this.page_size = 5
                this.paginate_total = 0
                this.oprion_id = value
                if(this.oprion_id == 1){
                    this.get_deposit_list()
                }else if(this.oprion_id == 2){
                    this.get_take_list()
                }else if(this.oprion_id ==3){
                    this.get_transfer_list()
                }
            }
        },
        mounted() {
            this.get_list()
        },
    }
</script>