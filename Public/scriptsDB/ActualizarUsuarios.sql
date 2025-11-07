-- Script para actualizar la base de datos existente
-- Agregar campo 'codigo' a la tabla usuarios

USE `treesolutiondb`;

-- Agregar columna 'codigo' a la tabla usuarios si no existe
ALTER TABLE `usuarios` 
ADD COLUMN IF NOT EXISTS `codigo` VARCHAR(10) NULL DEFAULT NULL AFTER `imagen`;

-- Agregar columna 'imagen' si no existe (por compatibilidad)
ALTER TABLE `usuarios` 
ADD COLUMN IF NOT EXISTS `imagen` VARCHAR(255) NULL DEFAULT 'user_generico.png' AFTER `usuario`;

-- Actualizar usuarios existentes que no tienen imagen
UPDATE `usuarios` SET `imagen` = 'user_generico.png' WHERE `imagen` IS NULL OR `imagen` = '';

-- Mostrar estructura actualizada
DESCRIBE `usuarios`;