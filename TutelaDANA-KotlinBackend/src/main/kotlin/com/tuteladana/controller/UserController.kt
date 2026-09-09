package com.tuteladana.controller

import com.tuteladana.repository.UserRepository
import io.ktor.server.application.call
import io.ktor.server.response.respond
import io.ktor.server.routing.Route
import io.ktor.server.routing.get

object UserController {
    private val userRepository = UserRepository

    fun register(route: Route) {
        route.get("/users") {
            val users = userRepository.list().map { user ->
                mapOf(
                    "id" to user.id,
                    "nombre" to user.nombre,
                    "email" to user.email,
                    "tonkens" to user.tonkens,
                    "fechaRegistro" to user.fechaRegistro
                )
            }
            call.respond(users)
        }
    }
}
