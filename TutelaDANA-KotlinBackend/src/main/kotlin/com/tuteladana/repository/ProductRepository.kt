package com.tuteladana.repository

import com.tuteladana.config.DatabaseConfig
import com.tuteladana.model.Product

object ProductRepository {
    fun getAll(): List<Product> {
        val products = mutableListOf<Product>()
        val sql = "SELECT * FROM productos ORDER BY nombre"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql).use { stmt ->
                stmt.executeQuery().use { rs ->
                    while (rs.next()) {
                        products.add(
                            mapProduct(rs)
                        )
                    }
                }
            }
        }
        return products
    }

    fun findById(id: Int): Product? {
        val sql = "SELECT id, nombre, descripcion, precio_tonkens FROM productos WHERE id = ?"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql).use { stmt ->
                stmt.setInt(1, id)
                stmt.executeQuery().use { rs ->
                    if (rs.next()) return mapProduct(rs)
                }
            }
        }
        return null
    }

    fun create(product: Product): Int {
        val sql = "INSERT INTO productos (nombre, descripcion, precio_tonkens) VALUES (?, ?, ?)"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql, java.sql.Statement.RETURN_GENERATED_KEYS).use { stmt ->
                stmt.setString(1, product.nombre)
                stmt.setString(2, product.descripcion ?: "")
                stmt.setInt(3, product.precioTonkens)
                stmt.executeUpdate()
                stmt.generatedKeys.use { keys ->
                    if (keys.next()) return keys.getInt(1)
                }
            }
        }
        return 0
    }

    fun update(product: Product): Boolean {
        val id = product.id ?: return false
        val sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio_tonkens = ? WHERE id = ?"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql).use { stmt ->
                stmt.setString(1, product.nombre)
                stmt.setString(2, product.descripcion ?: "")
                stmt.setInt(3, product.precioTonkens)
                stmt.setInt(4, id)
                return stmt.executeUpdate() > 0
            }
        }
    }

    fun delete(id: Int): Boolean {
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement("DELETE FROM productos WHERE id = ?").use { stmt ->
                stmt.setInt(1, id)
                return stmt.executeUpdate() > 0
            }
        }
    }

    private fun mapProduct(rs: java.sql.ResultSet): Product = Product(
        id = rs.getInt("id"),
        nombre = rs.getString("nombre"),
        precioTonkens = rs.getInt("precio_tonkens"),
        descripcion = rs.getString("descripcion")
    )
}
