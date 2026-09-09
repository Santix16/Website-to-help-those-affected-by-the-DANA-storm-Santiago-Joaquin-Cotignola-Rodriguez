package com.tuteladana.repository

import com.tuteladana.config.DatabaseConfig
import com.tuteladana.model.User

object UserRepository {
    fun list(): List<User> {
        val users = mutableListOf<User>()
        val sql = "SELECT id_usuario, nombre, email, password, tonkens, fecha_registro FROM usuarios ORDER BY nombre"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql).use { stmt ->
                stmt.executeQuery().use { rs ->
                    while (rs.next()) users.add(mapUser(rs))
                }
            }
        }
        return users
    }

    fun findByEmail(email: String): User? {
        val sql = "SELECT * FROM usuarios WHERE email = ? LIMIT 1"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql).use { stmt ->
                stmt.setString(1, email)
                stmt.executeQuery().use { rs ->
                    if (rs.next()) {
                        return mapUser(rs)
                    }
                }
            }
        }
        return null
    }

    fun create(user: User): Int {
        val sql = "INSERT INTO usuarios (nombre, email, password, tonkens) VALUES (?, ?, ?, ?)"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql, java.sql.Statement.RETURN_GENERATED_KEYS).use { stmt ->
                stmt.setString(1, user.nombre)
                stmt.setString(2, user.email)
                stmt.setString(3, user.password)
                stmt.setInt(4, user.tonkens)
                stmt.executeUpdate()
                val keys = stmt.generatedKeys
                if (keys.next()) {
                    return keys.getInt(1)
                }
            }
        }
        return 0
    }

    private fun mapUser(rs: java.sql.ResultSet): User = User(
        id = rs.getInt("id_usuario"),
        nombre = rs.getString("nombre"),
        email = rs.getString("email"),
        password = rs.getString("password"),
        tonkens = rs.getInt("tonkens"),
        fechaRegistro = rs.getTimestamp("fecha_registro")?.toString()
    )
}
