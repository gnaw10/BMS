DROP DATABASE IF EXISTS `BMS`;  -- books management system

CREATE SCHEMA IF NOT EXISTS `BMS` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `BMS` ;

-- -----------------------------------------------------
-- Table `BMS`.`user` 用户
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BMS`.`user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(50) NOT NULL, -- 用户名，英文开头，只包含英文和数字，长度不超过30
	`password` VARCHAR(50) NOT NULL, -- 密码，采用sha1(用户名+md5(原密码))加密，md5由前端加密传输
	`email` VARCHAR(100) NOT NULL, -- 邮箱
	`phone` VARCHAR(20) NOT NULL, -- 联系电话
	`gender` INT(1) NOT NULL, -- 性别 0（男）或1（女）
	`studentId` VARCHAR(30) NOT NULL, -- 学号
	`roleId` INT NOT NULL DEFAULT 4, -- 角色（对应role表中rid）
	`apikey` CHAR(100) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)ENGINE = InnoDB;

INSERT INTO `BMS`.`user` VALUES (1, 'admin', sha1(concat('admin', md5('admin'))), 'admin@admin.com', '12345678901', 0, '0', 1,'123456789');

-- -----------------------------------------------------
-- Table `BMS`.`role` 用户角色
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BMS`.`role` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL, -- 角色名称
	`timeLimit` INT NOT NULL DEFAULT 30, -- 归还期限(天数)
	`numLimit` INT NOT NULL DEFAULT 5, -- 借书数量限制
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)ENGINE = InnoDB;
INSERT INTO `BMS`.`role` VALUES (1, '管理员', 30 ,5);
INSERT INTO `BMS`.`role` VALUES (2, '老师', 30 ,5);
INSERT INTO `BMS`.`role` VALUES (3, '学生', 30 ,5);
INSERT INTO `BMS`.`role` VALUES (4, '临时帐号', 0 ,0);

-- -----------------------------------------------------
-- Table `BMS`.`book` 图书
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BMS`.`book` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`inTime` INT NOT NULL, -- 创建时间，秒级
	`outTime` INT NOT NULL, -- 修改时间，秒级
	`name` VARCHAR(50) NOT NULL, -- 图书名称
	`user_id` INT NOT NULL, -- 关联用户名
	`coverUrl` VARCHAR(50) NOT NULL, -- 图书封面图片
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `BMS`.`log` 书评记录
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BMS`.`log` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`title` TEXT NOT NULL, -- 名称
	`body` TEXT NOT NULL, -- 内容
	`user_id` INT NOT NULL, -- 创建人
	`book_id` INT NOT NULL, -- 相关图书
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)ENGINE = InnoDB;
