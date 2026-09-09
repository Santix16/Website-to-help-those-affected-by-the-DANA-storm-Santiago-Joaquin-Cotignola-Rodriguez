package com.tuteladana.controller

import com.tuteladana.model.User
import com.tuteladana.repository.UserRepository
import io.ktor.http.HttpStatusCode
import io.ktor.server.application.call
import io.ktor.server.request.receive
import io.ktor.server.response.respond
import io.ktor.server.routing.Route
import io.ktor.server.routing.post
import org.mindrot.jbcrypt.BCrypt

object AuthController {
    private val userRepository = UserRepository

    @kotlinx.serialization.Serializable
    private data class LoginRequest(val email: String, val password: String)

    @kotlinx.serialization.Serializable
    private data class PublicUser(val id: Int?, val nombre: String, val email: String, val tonkens: Int)

    fun register(route: Route) {
        route.post("/auth/register") {
            val user = call.receive<User>()
            if (user.nombre.isBlank() || !user.email.contains("@") || user.password.length < 8) {
                call.respond(HttpStatusCode.BadRequest, mapOf("message" to "Datos de registro inválidos"))
                return@post
            }
            val exists = userRepository.findByEmail(user.email)
            if (exists != null) {
                call.respond(HttpStatusCode.Conflict, mapOf("message" to "El email ya está registrado"))
                return@post
            }

            val id = userRepository.create(user.copy(password = BCrypt.hashpw(user.password, BCrypt.gensalt())))
            call.respond(HttpStatusCode.Created, mapOf("id" to id, "message" to "Usuario registrado"))
        }

        route.post("/auth/login") {
            val body = call.receive<LoginRequest>()
            val email = body.email.trim()
            val user = userRepository.findByEmail(email)

            if (user != null && BCrypt.checkpw(body.password, user.password)) {
                call.respond(
                    HttpStatusCode.OK,
                    mapOf("message" to "Login correcto", "user" to PublicUser(user.id, user.nombre, user.email, user.tonkens))
                )
            } else {
                call.respond(HttpStatusCode.Unauthorized, mapOf("message" to "Credenciales inválidas"))
            }
        }
    }
}
