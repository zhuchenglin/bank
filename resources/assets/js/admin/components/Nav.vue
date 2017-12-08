<template>
    <div>
        <div class="menu_nav_left">
            <el-menu default-active="0" class="el-menu-vertical-demo"
                     @select="click_menu" :collapse="isCollapse">
                <el-menu-item index="0">
                    <i class="el-icon-menu menu_icon"></i>
                    <span slot="title">{{ isCollapse ? '显示菜单' : '隐藏菜单' }}</span>
                </el-menu-item>
                <!--<el-menu-item index="1">-->
                    <!--<i class="ion-person menu_icon"></i>-->
                    <!--<span slot="title">用户管理</span>-->
                <!--</el-menu-item>-->
                <el-submenu index="1">
                    <template slot="title">
                        <i class="ion-person menu_icon"></i>
                        <span slot="title">用户管理</span>
                    </template>
                    <el-menu-item-group>
                        <el-menu-item index="1-1">用户列表</el-menu-item>
                        <el-menu-item index="1-2">新增用户</el-menu-item>
                    </el-menu-item-group>
                </el-submenu>
                <el-menu-item index="2">
                    <i class="ion-card menu_icon"></i>
                    <span slot="title">账户管理</span>
                </el-menu-item>
                <el-menu-item index="3">
                    <i class="ion-android-clipboard menu_icon"></i>
                    <span slot="title">交易记录</span>
                </el-menu-item>
                <!--<el-submenu index="1">-->
                    <!--<template slot="title">-->
                        <!--<i class="ion-person menu_icon"></i>-->
                        <!--<span slot="title">用户管理</span>-->
                    <!--</template>-->
                    <!--<el-menu-item-group>-->
                        <!--<el-menu-item index="1-1">我的资料</el-menu-item>-->
                        <!--<el-menu-item index="1-2">注销登录</el-menu-item>-->
                    <!--</el-menu-item-group>-->
                <!--</el-submenu>-->
                <!--<el-submenu index="2">-->
                    <!--<template slot="title">-->
                        <!--<i class="ion-ios-gear menu_icon"></i>-->
                        <!--<span slot="title">我的</span>-->
                    <!--</template>-->
                    <!--<el-menu-item-group>-->
                        <!--<el-menu-item index="2-1">我的资料</el-menu-item>-->
                        <!--<el-menu-item index="2-2">注销登录</el-menu-item>-->
                    <!--</el-menu-item-group>-->
                <!--</el-submenu>-->
                <!--<el-submenu index="3">-->
                    <!--<template slot="title">-->
                        <!--<i class="ion-ios-gear menu_icon"></i>-->
                        <!--<span slot="title">我的</span>-->
                    <!--</template>-->
                    <!--<el-menu-item-group>-->
                        <!--<el-menu-item index="3-1">我的资料</el-menu-item>-->
                        <!--<el-menu-item index="3-2">注销登录</el-menu-item>-->
                    <!--</el-menu-item-group>-->
                <!--</el-submenu>-->
                <el-submenu index="4">
                    <template slot="title">
                        <i class="ion-ios-gear menu_icon"></i>
                        <span slot="title">我的</span>
                    </template>
                    <el-menu-item-group>
                        <el-menu-item index="4-1">个人中心</el-menu-item>
                        <el-menu-item index="4-2">注销登录</el-menu-item>
                    </el-menu-item-group>
                </el-submenu>
            </el-menu>
        </div>
        <el-dialog title="新增用户" :visible.sync="show_create_user_dialog" v-loading="create_user_is_loading"
        element-loading-text="拼命加载中"
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
            <el-form :model="user_info">
                <el-form-item label="用户姓名" :label-width="formLabelWidth">
                    <el-input v-model="user_info.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="用户账号" :label-width="formLabelWidth">
                    <el-input v-model="user_info.account" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="身份证号" :label-width="formLabelWidth">
                    <el-input v-model="user_info.ID_card" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="电话号" :label-width="formLabelWidth">
                    <el-input v-model="user_info.phone" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="show_create_user_dialog = false">取 消</el-button>
                <el-button type="primary" @click="create_user();">确 定</el-button>
            </div>
        </el-dialog>
        <router-view></router-view>
    </div>
</template>

<style scoped>
    .el-menu-vertical-demo:not(.el-menu--collapse) {
        width: 200px;
        min-height: 400px;
    }
    .menu_icon {
        font-size: 20px;
        margin-right: 10px;
    }
    .menu_nav_left{
        float: left;
    }
</style>

<script scoped>

    export default {
        data() {
            return {
                isCollapse: true,
                show_create_user_dialog:false,
                can_create:true,
                user_info:{
                    name:'',
                    account:'',
                    ID_card:'',
                    phone:'',
                },
                formLabelWidth: '120px',
                create_user_is_loading:false,
            }
        },
        components: {},
        computed: {},
        methods: {
            handleOpen(key, keyPath) {
                console.log(key)
                $('.el-table').css('width','80% !important');
            },
            handleClose(key, keyPath) {
                $('.el-table').css('width','90% !important');
            },
            create_user(){
                if(this.user_info.name==''){
                    this.show_message('用户姓名不能为空！','warning');
                    return ;
                }
                if(this.user_info.account==''){
                    this.show_message('用户账号不能为空！','warning');
                    return ;
                }
                if(this.user_info.ID_card==''){
                    this.show_message('用户身份证号不能为空！','warning');
                    return ;
                }
                if(this.user_info.phone==''){
                    this.show_message('用户电话号不能为空！','warning');
                    return;
                }
                if(this.can_create){
                    this.can_create = false;
                    this.create_user_is_loading = true;
                    let data = {
                        user_info:this.user_info
                    };
                    this.send_request('post','/admin/user/create',function (response,self) {
                        self.can_create = true;
                        if(response.data.code==0){
                            self.show_message(response.data.msg,'success');
                            self.create_user_is_loading = false;
                            self.show_create_user_dialog = false;
                            location.reload();
                        }else{
                            self.show_message(response.data.msg,'warning');
                        }
                    },data);
                }
            },

            click_menu(index) {
                console.log(index);
                switch (index){
                    case '0':
                        this.isCollapse = !this.isCollapse;
                        break;
                    case '1-1':
                        this.$router.push('/nav/user/index');
                        break;
                    case  '1-2':
                        if(this.can_create){
                            this.show_create_user_dialog = true;
                        }
                        break;
                }
            },
        },
        mounted() {
        },
    }
</script>