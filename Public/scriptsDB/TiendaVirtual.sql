SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema TreeSolutionDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema TreeSolutionDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `TreeSolutionDB` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema treesolutiondb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema treesolutiondb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `treesolutiondb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `TreeSolutionDB` ;

-- -----------------------------------------------------
-- Table `treesolutiondb`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `treesolutiondb`.`usuarios` (
  `ID_Usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `apellido` VARCHAR(50) NOT NULL,
  `dni` VARCHAR(10) NOT NULL,
  `telefono` VARCHAR(20) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `contrasena` VARCHAR(10) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`ID_Usuario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `TreeSolutionDB`.`empleados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TreeSolutionDB`.`empleados` (
  `ID_Empleado` INT NOT NULL AUTO_INCREMENT,
  `ID_Usuario` INT NOT NULL,
  `tipo` ENUM('Administrador', 'Empleado') NOT NULL,
  PRIMARY KEY (`ID_Empleado`),
  INDEX `fk_empleados_usuarios_idx` (`ID_Usuario` ASC) VISIBLE,
  CONSTRAINT `fk_empleados_usuarios`
    FOREIGN KEY (`ID_Usuario`)
    REFERENCES `treesolutiondb`.`usuarios` (`ID_Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `treesolutiondb` ;

-- -----------------------------------------------------
-- Table `treesolutiondb`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `treesolutiondb`.`clientes` (
  `ID_Cliente` INT NOT NULL AUTO_INCREMENT,
  `ID_Usuario` INT NOT NULL,
  `direccion` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_Cliente`),
  INDEX `ID_Usuario` (`ID_Usuario` ASC) VISIBLE,
  CONSTRAINT `clientes_ibfk_1`
    FOREIGN KEY (`ID_Usuario`)
    REFERENCES `treesolutiondb`.`usuarios` (`ID_Usuario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `treesolutiondb`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `treesolutiondb`.`pedidos` (
  `ID_Pedido` INT NOT NULL AUTO_INCREMENT,
  `fechaPedido` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estadoPedido` VARCHAR(50) NULL DEFAULT NULL,
  `totalPedido` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_Pedido`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `treesolutiondb`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `treesolutiondb`.`productos` (
  `ID_Producto` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `descripcion` VARCHAR(255) NULL DEFAULT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `imagen` VARCHAR(255) NULL,
  PRIMARY KEY (`ID_Producto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `treesolutiondb`.`detallespedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `treesolutiondb`.`detallespedido` (
  `ID_DetallePedido` INT NOT NULL AUTO_INCREMENT,
  `ID_Pedido` INT NOT NULL,
  `ID_Producto` INT NOT NULL,
  `cantidad` INT NULL DEFAULT NULL,
  `precioUnitario` DECIMAL(10,2) NULL DEFAULT NULL,
  `subtotal` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_DetallePedido`),
  INDEX `ID_Pedido` (`ID_Pedido` ASC) VISIBLE,
  INDEX `ID_Producto` (`ID_Producto` ASC) VISIBLE,
  CONSTRAINT `detallespedido_ibfk_2`
    FOREIGN KEY (`ID_Pedido`)
    REFERENCES `treesolutiondb`.`pedidos` (`ID_Pedido`),
  CONSTRAINT `detallespedido_ibfk_3`
    FOREIGN KEY (`ID_Producto`)
    REFERENCES `treesolutiondb`.`productos` (`ID_Producto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `treesolutiondb`.`ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `treesolutiondb`.`ventas` (
  `ID_Venta` INT NOT NULL AUTO_INCREMENT,
  `ID_Cliente` INT NOT NULL,
  `ID_Empleado` INT NOT NULL,
  `fechaVenta` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` DECIMAL(10,2) NOT NULL,
  `tipoPago` ENUM('Efectivo', 'Tarjeta') NOT NULL,
  PRIMARY KEY (`ID_Venta`),
  INDEX `ID_Cliente` (`ID_Cliente` ASC) VISIBLE,
  INDEX `fk_ventas_empleados1_idx` (`ID_Empleado` ASC) VISIBLE,
  CONSTRAINT `ventas_ibfk_1`
    FOREIGN KEY (`ID_Cliente`)
    REFERENCES `treesolutiondb`.`clientes` (`ID_Cliente`),
  CONSTRAINT `fk_ventas_empleados1`
    FOREIGN KEY (`ID_Empleado`)
    REFERENCES `TreeSolutionDB`.`empleados` (`ID_Empleado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `treesolutiondb`.`detalleventa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `treesolutiondb`.`detalleventa` (
  `ID_DetalleVenta` INT NOT NULL AUTO_INCREMENT,
  `ID_Venta` INT NOT NULL,
  `ID_Producto` INT NOT NULL,
  `cantidad` INT NOT NULL,
  `precio_Unitario` DECIMAL(10,2) NULL DEFAULT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`ID_DetalleVenta`),
  INDEX `ID_Venta` (`ID_Venta` ASC) VISIBLE,
  INDEX `ID_Producto` (`ID_Producto` ASC) VISIBLE,
  CONSTRAINT `detalleventa_ibfk_1`
    FOREIGN KEY (`ID_Venta`)
    REFERENCES `treesolutiondb`.`ventas` (`ID_Venta`),
  CONSTRAINT `detalleventa_ibfk_2`
    FOREIGN KEY (`ID_Producto`)
    REFERENCES `treesolutiondb`.`productos` (`ID_Producto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;





-- Insertando datos iniciales en las tablas

INSERT INTO `usuarios` (`nombre`, `apellido`, `dni`, `telefono`, `email`, `contrasena`, `usuario`)
VALUES
  ('Nombre1', 'Apellido1', '12345678A', '1234567890', 'usuario1@example.com', 'password1', 'usuario1'),
  ('Nombre2', 'Apellido2', '12345678B', '1234567891', 'usuario2@example.com', 'password2', 'usuario2'),
  ('Nombre3', 'Apellido3', '12345678C', '1234567892', 'usuario3@example.com', 'password3', 'usuario3'),
  ('Nombre4', 'Apellido4', '12345678D', '1234567893', 'usuario4@example.com', 'password4', 'usuario4'),
  ('Nombre5', 'Apellido5', '12345678E', '1234567894', 'usuario5@example.com', 'password5', 'usuario5'),
  ('Nombre6', 'Apellido6', '12345678F', '1234567895', 'usuario6@example.com', 'password6', 'usuario6'),
  ('Nombre7', 'Apellido7', '12345678G', '1234567896', 'usuario7@example.com', 'password7', 'usuario7'),
  ('Nombre8', 'Apellido8', '12345678H', '1234567897', 'usuario8@example.com', 'password8', 'usuario8'),
  ('Nombre9', 'Apellido9', '12345678I', '1234567898', 'usuario9@example.com', 'password9', 'usuario9'),
  ('Nombre10', 'Apellido10', '12345678J', '1234567899', 'usuario10@example.com', '1234', 'empleado'),
  ('Germán', 'Callupe', '12345678K', '1234567800', 'german@example.com', '1234', 'german');

-- Insert data into empleados table (Administrador)
INSERT INTO `empleados` (`ID_Usuario`, `tipo`)
SELECT ID_Usuario, 'Administrador'
FROM `usuarios`
WHERE usuario = 'german' AND contrasena = '1234';

-- Insert data into empleados table (Empleado)
INSERT INTO `empleados` (`ID_Usuario`, `tipo`)
SELECT ID_Usuario, 'Empleado'
FROM `usuarios`
WHERE usuario = 'empleado' AND contrasena = '1234'
LIMIT 1;

-- Insert data into clientes table
INSERT INTO `clientes` (`ID_Usuario`, `direccion`)
VALUES
  ((SELECT ID_Usuario FROM `usuarios` WHERE usuario = 'usuario1'), 'Dirección Cliente 1'),
  ((SELECT ID_Usuario FROM `usuarios` WHERE usuario = 'usuario2'), 'Dirección Cliente 2');

-- Insert data into productos table
INSERT INTO `productos` (`nombre`, `descripcion`, `precio`)
VALUES
  ('Camiseta deportiva', 'Camiseta transpirable para deportes', 19.99),
  ('Pantalón deportivo', 'Pantalón cómodo para entrenamiento', 29.99),
  ('Zapatillas de running', 'Zapatillas ligeras y amortiguadas', 59.99),
  ('Calcetines deportivos', 'Calcetines ergonómicos para deporte', 9.99),
  ('Shorts deportivos', 'Shorts de secado rápido', 24.99),
  ('Sudadera deportiva', 'Sudadera ligera para actividades al aire libre', 39.99),
  ('Chaqueta cortavientos', 'Chaqueta impermeable y transpirable', 49.99),
  ('Mallas deportivas', 'Mallas compresivas para entrenamiento', 34.99),
  ('Gorra deportiva', 'Gorra ajustable para protección solar', 14.99),
  ('Bolsa deportiva', 'Bolsa resistente para llevar equipo deportivo', 29.99);

