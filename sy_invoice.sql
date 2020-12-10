/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : sy_invoice

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 08/12/2020 11:20:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '发票id',
  `crm_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT 'crmId',
  `invoice_company` int(11) NOT NULL DEFAULT 10  COMMENT '开票公司 10上海双于/20深圳是方/30江西双格',
  `uid` int(11) NOT NULL COMMENT '业务员Id',
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '公司名',
  `ticket_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '开票名',
  `tax_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '税号',
  `address_mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '地址/电话',
  `bank_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '开户行/账户',
  `money` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '金额',
  `invoice_type` int(11) NOT NULL DEFAULT 10  COMMENT '发票类型 10普票/20专票/30收据',
  `express` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递信息',
  `express_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '快递单号',
  `ticket_month` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '开票月份',
  `ticket_day` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '到期提醒日',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注',
  `blank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '空字段预留',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '10未开票/20已开票/90发票作废',
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `crm_id`(`crm_id`) USING BTREE,
  INDEX `ticket_day`(`ticket_day`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1001 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '发票表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of invoice
-- ----------------------------
INSERT INTO `invoice` VALUES (1001, '20E0671C95BA', 10, 1002, '客户名1', '华信塞姆科技有限公司', '91510000321690065M', '四川省成都市高新区天华一路99号天府软件园B区8栋/028-66048388', '工行成都市城南支行/3302235009100139999', '5000', 10,'王志成，13378102298，四川省成都市高新区天府大道天府软件园B区8栋5楼', 'SF6546654132','1596240000', '2020-12-08', '','',10, '2020-07-17 06:51:58', '2020-12-07 09:42:54');
INSERT INTO `invoice` VALUES (1002, '01E0671C95BA', 20, 1002, '客户名2', '中泰科技技术有限公司', '78645670321690065M', '四川省成都市高新区天华一路99号天府软件园B区8栋/028-66048388', '工行成都市城南支行/3302235009100188888', '8000', 20,'赵志成，13378102298，四川省成都市高新区天府大道天府软件园B区8栋5楼', 'SF6544440888','1596240000', '2020-12-09', '','', 20,'2020-07-17 06:51:58', '2020-11-26 07:28:39');
INSERT INTO `invoice` VALUES (1003, '72E0671C95BA', 30, 1002, '客户名3', '泰星科技技术有限公司', '36490000321690065M', '四川省成都市高新区天华一路99号天府软件园B区8栋/023-44946561', '工行成都市城南支行/2202235009100177777', '9000', 30,'李志成，13378102298，四川省成都市高新区天府大道天府软件园B区8栋5楼', 'SF6581111132','1596240000', '2020-12-04', '','',90, '2020-07-17 06:51:58', '2020-11-25 01:20:15');

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `per_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '权限名',
  `per_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'url',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '状态/10正常/90删除',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `per_name`(`per_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1048 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (1001, '用户列表页', 'App\\Http\\Controllers\\Admin\\UserController@index', 10);
INSERT INTO `permission` VALUES (1002, '用户添加页', 'App\\Http\\Controllers\\Admin\\UserController@add', 10);
INSERT INTO `permission` VALUES (1003, '用户添加', 'App\\Http\\Controllers\\Admin\\UserController@create', 10);
INSERT INTO `permission` VALUES (1004, '用户删除', 'App\\Http\\Controllers\\Admin\\UserController@delete', 10);
INSERT INTO `permission` VALUES (1005, '用户修改页', 'App\\Http\\Controllers\\Admin\\UserController@edit', 10);
INSERT INTO `permission` VALUES (1006, '用户修改', 'App\\Http\\Controllers\\Admin\\UserController@update', 10);
INSERT INTO `permission` VALUES (1007, '分配角色页', 'App\\Http\\Controllers\\Admin\\UserController@distributePage', 10);
INSERT INTO `permission` VALUES (1008, '分配角色', 'App\\Http\\Controllers\\Admin\\UserController@distribute', 10);
INSERT INTO `permission` VALUES (1009, '角色列表页', 'App\\Http\\Controllers\\Admin\\RoleController@index', 10);
INSERT INTO `permission` VALUES (1010, '角色添加页', 'App\\Http\\Controllers\\Admin\\RoleController@add', 10);
INSERT INTO `permission` VALUES (1011, '角色添加', 'App\\Http\\Controllers\\Admin\\RoleController@create', 10);
INSERT INTO `permission` VALUES (1012, '角色删除', 'App\\Http\\Controllers\\Admin\\RoleController@delete', 10);
INSERT INTO `permission` VALUES (1013, '角色修改页', 'App\\Http\\Controllers\\Admin\\RoleController@edit', 10);
INSERT INTO `permission` VALUES (1014, '角色修改', 'App\\Http\\Controllers\\Admin\\RoleController@update', 10);
INSERT INTO `permission` VALUES (1015, '角色授权页', 'App\\Http\\Controllers\\Admin\\RoleController@auth', 10);
INSERT INTO `permission` VALUES (1016, '角色授权', 'App\\Http\\Controllers\\Admin\\RoleController@doAuth', 10);
INSERT INTO `permission` VALUES (1017, '权限列表页', 'App\\Http\\Controllers\\Admin\\PermissionController@index', 10);
INSERT INTO `permission` VALUES (1018, '权限添加页', 'App\\Http\\Controllers\\Admin\\PermissionController@add', 10);
INSERT INTO `permission` VALUES (1019, '权限添加', 'App\\Http\\Controllers\\Admin\\PermissionController@create', 10);
INSERT INTO `permission` VALUES (1020, '权限删除', 'App\\Http\\Controllers\\Admin\\PermissionController@delete', 10);
INSERT INTO `permission` VALUES (1021, '权限修改页', 'App\\Http\\Controllers\\Admin\\PermissionController@edit', 10);
INSERT INTO `permission` VALUES (1022, '权限修改', 'App\\Http\\Controllers\\Admin\\PermissionController@update', 10);
INSERT INTO `permission` VALUES (1023, '产品列表', 'App\\Http\\Controllers\\Admin\\ProductController@index', 10);
INSERT INTO `permission` VALUES (1024, '产品添加页', 'App\\Http\\Controllers\\Admin\\ProductController@add', 10);
INSERT INTO `permission` VALUES (1025, '产品添加', 'App\\Http\\Controllers\\Admin\\ProductController@create', 10);
INSERT INTO `permission` VALUES (1026, '产品删除', 'App\\Http\\Controllers\\Admin\\ProductController@delete', 10);
INSERT INTO `permission` VALUES (1027, '产品修改页', 'App\\Http\\Controllers\\Admin\\ProductController@edit', 10);
INSERT INTO `permission` VALUES (1028, '产品修改', 'App\\Http\\Controllers\\Admin\\ProductController@update', 10);
INSERT INTO `permission` VALUES (1029, '客户列表页', 'App\\Http\\Controllers\\Admin\\CustomerController@index', 10);
INSERT INTO `permission` VALUES (1030, '客户添加页', 'App\\Http\\Controllers\\Admin\\CustomerController@add', 10);
INSERT INTO `permission` VALUES (1031, '客户添加', 'App\\Http\\Controllers\\Admin\\CustomerController@create', 10);
INSERT INTO `permission` VALUES (1032, '客户删除', 'App\\Http\\Controllers\\Admin\\CustomerController@delete', 10);
INSERT INTO `permission` VALUES (1033, '客户修改页', 'App\\Http\\Controllers\\Admin\\CustomerController@edit', 10);
INSERT INTO `permission` VALUES (1034, '客户修改', 'App\\Http\\Controllers\\Admin\\CustomerController@update', 10);
INSERT INTO `permission` VALUES (1035, '客户已购产品', 'App\\Http\\Controllers\\Admin\\CustomerController@purchased', 10);
INSERT INTO `permission` VALUES (1036, '添加已购产品', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedAdd', 10);
INSERT INTO `permission` VALUES (1037, '客户已购产品修改页', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedEdit', 10);
INSERT INTO `permission` VALUES (1038, '客户已购产品删除', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedDelete', 10);
INSERT INTO `permission` VALUES (1039, '客户已购产品修改', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedUpdate', 10);
INSERT INTO `permission` VALUES (1040, '客户已购产品添加方法', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedCreate', 10);
INSERT INTO `permission` VALUES (1041, '发票列表页', 'App\\Http\\Controllers\\Admin\\InvoiceController@index', 10);
INSERT INTO `permission` VALUES (1042, '发票添加页', 'App\\Http\\Controllers\\Admin\\InvoiceController@add', 10);
INSERT INTO `permission` VALUES (1043, '发票添加', 'App\\Http\\Controllers\\Admin\\InvoiceController@create', 10);
INSERT INTO `permission` VALUES (1044, '发票删除', 'App\\Http\\Controllers\\Admin\\InvoiceController@delete', 10);
INSERT INTO `permission` VALUES (1045, '发票修改页', 'App\\Http\\Controllers\\Admin\\InvoiceController@edit', 10);
INSERT INTO `permission` VALUES (1046, '发票修改', 'App\\Http\\Controllers\\Admin\\InvoiceController@update', 10);
INSERT INTO `permission` VALUES (1047, '导出发票信息', 'App\\Http\\Controllers\\Admin\\InvoiceController@ExcelGet', 10);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '角色名',
  `sign` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标识',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '状态/10正常/90删除',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `rolename`(`rolename`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1004 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1001, '超级管理员', 'administrator', 10);
INSERT INTO `role` VALUES (1002, '管理员', 'admin', 10);
INSERT INTO `role` VALUES (1003, '业务员', 'business', 10);

-- ----------------------------
-- Table structure for role_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '角色id',
  `pid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '权限id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1656 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色权限分配表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_permission
-- ----------------------------
INSERT INTO `role_permission` VALUES (1596, '1002', '1041');
INSERT INTO `role_permission` VALUES (1597, '1002', '1042');
INSERT INTO `role_permission` VALUES (1598, '1002', '1043');
INSERT INTO `role_permission` VALUES (1599, '1002', '1044');
INSERT INTO `role_permission` VALUES (1600, '1002', '1045');
INSERT INTO `role_permission` VALUES (1601, '1002', '1046');
INSERT INTO `role_permission` VALUES (1602, '1002', '1047');
INSERT INTO `role_permission` VALUES (1603, '1001', '1001');
INSERT INTO `role_permission` VALUES (1604, '1001', '1002');
INSERT INTO `role_permission` VALUES (1605, '1001', '1003');
INSERT INTO `role_permission` VALUES (1606, '1001', '1004');
INSERT INTO `role_permission` VALUES (1607, '1001', '1005');
INSERT INTO `role_permission` VALUES (1608, '1001', '1006');
INSERT INTO `role_permission` VALUES (1609, '1001', '1007');
INSERT INTO `role_permission` VALUES (1610, '1001', '1008');
INSERT INTO `role_permission` VALUES (1611, '1001', '1009');
INSERT INTO `role_permission` VALUES (1612, '1001', '1010');
INSERT INTO `role_permission` VALUES (1613, '1001', '1011');
INSERT INTO `role_permission` VALUES (1614, '1001', '1012');
INSERT INTO `role_permission` VALUES (1615, '1001', '1013');
INSERT INTO `role_permission` VALUES (1616, '1001', '1014');
INSERT INTO `role_permission` VALUES (1617, '1001', '1015');
INSERT INTO `role_permission` VALUES (1618, '1001', '1016');
INSERT INTO `role_permission` VALUES (1619, '1001', '1017');
INSERT INTO `role_permission` VALUES (1620, '1001', '1018');
INSERT INTO `role_permission` VALUES (1621, '1001', '1019');
INSERT INTO `role_permission` VALUES (1622, '1001', '1020');
INSERT INTO `role_permission` VALUES (1623, '1001', '1021');
INSERT INTO `role_permission` VALUES (1624, '1001', '1022');
INSERT INTO `role_permission` VALUES (1625, '1001', '1023');
INSERT INTO `role_permission` VALUES (1626, '1001', '1024');
INSERT INTO `role_permission` VALUES (1627, '1001', '1025');
INSERT INTO `role_permission` VALUES (1628, '1001', '1026');
INSERT INTO `role_permission` VALUES (1629, '1001', '1027');
INSERT INTO `role_permission` VALUES (1630, '1001', '1028');
INSERT INTO `role_permission` VALUES (1631, '1001', '1029');
INSERT INTO `role_permission` VALUES (1632, '1001', '1030');
INSERT INTO `role_permission` VALUES (1633, '1001', '1031');
INSERT INTO `role_permission` VALUES (1634, '1001', '1032');
INSERT INTO `role_permission` VALUES (1635, '1001', '1033');
INSERT INTO `role_permission` VALUES (1636, '1001', '1034');
INSERT INTO `role_permission` VALUES (1637, '1001', '1035');
INSERT INTO `role_permission` VALUES (1638, '1001', '1036');
INSERT INTO `role_permission` VALUES (1639, '1001', '1037');
INSERT INTO `role_permission` VALUES (1640, '1001', '1038');
INSERT INTO `role_permission` VALUES (1641, '1001', '1039');
INSERT INTO `role_permission` VALUES (1642, '1001', '1040');
INSERT INTO `role_permission` VALUES (1643, '1001', '1041');
INSERT INTO `role_permission` VALUES (1644, '1001', '1042');
INSERT INTO `role_permission` VALUES (1645, '1001', '1043');
INSERT INTO `role_permission` VALUES (1646, '1001', '1044');
INSERT INTO `role_permission` VALUES (1647, '1001', '1045');
INSERT INTO `role_permission` VALUES (1648, '1001', '1046');
INSERT INTO `role_permission` VALUES (1649, '1001', '1047');
INSERT INTO `role_permission` VALUES (1652, '1003', '1041');
INSERT INTO `role_permission` VALUES (1653, '1003', '1045');
INSERT INTO `role_permission` VALUES (1654, '1003', '1046');
INSERT INTO `role_permission` VALUES (1655, '1003', '1047');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '账号/用户名称',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '公司名称',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '公司地址',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '状态/10正常/20即将到期/90删除',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间/账号创建时间',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '修改时间/用户资料修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `email`(`email`(50)) USING BTREE,
  INDEX `mobile`(`mobile`) USING BTREE,
  INDEX `company`(`company`(50)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1017 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1001, 'admin', '4297f44b13955235245b2497399d7a93', '上海双于通信有限公司1', '12345671@qq.com', '18888888888', '上海市真北路321312312312号19楼', 10, '2020-07-17 14:51:58', '2020-07-29 07:41:29');
INSERT INTO `user` VALUES (1002, 'business', '4297f44b13955235245b2497399d7a93', '上海双于通信有限公司2', '12345672@qq.com', '18888888882', '123', 10, '2020-07-17 14:51:58', '2020-11-02 02:08:09');
INSERT INTO `user` VALUES (1003, 'guanli', '4297f44b13955235245b2497399d7a93', '123', '123', '123', '123', 10, '2020-07-17 14:51:58', '2020-11-02 02:19:13');

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `rid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1157 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户角色分配表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES (1030, 1010, '1001');
INSERT INTO `user_role` VALUES (1031, 1010, '1002');
INSERT INTO `user_role` VALUES (1032, 1010, '1003');
INSERT INTO `user_role` VALUES (1033, 1010, '1001');
INSERT INTO `user_role` VALUES (1034, 1010, '1002');
INSERT INTO `user_role` VALUES (1035, 1010, '1003');
INSERT INTO `user_role` VALUES (1069, 1011, '1001');
INSERT INTO `user_role` VALUES (1070, 1011, '1002');
INSERT INTO `user_role` VALUES (1071, 1011, '1003');
INSERT INTO `user_role` VALUES (1130, 1004, '1001');
INSERT INTO `user_role` VALUES (1131, 1004, '1002');
INSERT INTO `user_role` VALUES (1132, 1004, '1003');
INSERT INTO `user_role` VALUES (1141, 1012, '1001');
INSERT INTO `user_role` VALUES (1142, 1012, '1002');
INSERT INTO `user_role` VALUES (1143, 1012, '1003');
INSERT INTO `user_role` VALUES (1145, 1015, '1001');
INSERT INTO `user_role` VALUES (1146, 1015, '1002');
INSERT INTO `user_role` VALUES (1147, 1015, '1003');
INSERT INTO `user_role` VALUES (1148, 1001, '1001');
INSERT INTO `user_role` VALUES (1149, 1001, '1002');
INSERT INTO `user_role` VALUES (1150, 1001, '1003');
INSERT INTO `user_role` VALUES (1151, 1016, '1001');
INSERT INTO `user_role` VALUES (1152, 1016, '1002');
INSERT INTO `user_role` VALUES (1153, 1016, '1003');
INSERT INTO `user_role` VALUES (1154, 1002, '1003');
INSERT INTO `user_role` VALUES (1156, 1003, '1002');

SET FOREIGN_KEY_CHECKS = 1;
