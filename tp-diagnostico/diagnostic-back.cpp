#include <mysql/mysql.h>
#include <iostream>
#include <string>
#include <sstream>
#include <sys/socket.h>
#include <netinet/in.h>
#include <unistd.h>
#include <cstring>

const int PORT = 8080;
const std::string SERVER_RESPONSE_HEADER = "HTTP/1.1 200 OK\r\nContent-Type: application/json\r\n\r\n";
const std::string NOT_FOUND_RESPONSE = "HTTP/1.1 404 Not Found\r\nContent-Type: text/plain\r\n\r\n404 Not Found";

// Execute querys to database
bool ejecutarConsulta(MYSQL *conn, const std::string& query, std::string& result) {
    if (mysql_query(conn, query.c_str()) != 0) {
        std::cerr << "Error en la consulta a la base de datos." << std::endl;
        return false;
    }

    MYSQL_RES *res = mysql_store_result(conn);
    if (res == NULL) {
        std::cerr << "Error al obtener resultados de la consulta." << std::endl;
        return false;
    }

    MYSQL_ROW row;
    while ((row = mysql_fetch_row(res)) != NULL) {
        for (unsigned int i = 0; i < mysql_num_fields(res); i++) {
            result += row[i] ? row[i] : "NULL";
            if (i != mysql_num_fields(res) - 1) {
                result += ",";
            }
        }
        result += "\n";
    }

    mysql_free_result(res);
    return true;
}

// Handle http querys
void handle_request(int client_socket, MYSQL *conn) {
    char buffer[1024] = {0};
    read(client_socket, buffer, sizeof(buffer));

    std::string request(buffer);
    std::istringstream iss(request);
    std::string method, path;
    iss >> method >> path;

    if (method != "GET") {
        write(client_socket, NOT_FOUND_RESPONSE.c_str(), NOT_FOUND_RESPONSE.size());
        close(client_socket);
        return;
    }

    std::string response = SERVER_RESPONSE_HEADER;

    // Handle query depending on path
    if (path == "/obtener_provincias") {
        std::string query = "SELECT * FROM provincia";
        std::string result;
        if (!ejecutarConsulta(conn, query, result)) {
            write(client_socket, NOT_FOUND_RESPONSE.c_str(), NOT_FOUND_RESPONSE.size());
            close(client_socket);
            return;
        }
        response += result;
    } else if (path == "/obtener_departamentos") {
        std::string provincia;
        iss >> provincia;
        std::string query = "SELECT * FROM departamento WHERE id_provincia = " + provincia;
        std::string result;
        if (!ejecutarConsulta(conn, query, result)) {
            write(client_socket, NOT_FOUND_RESPONSE.c_str(), NOT_FOUND_RESPONSE.size());
            close(client_socket);
            return;
        }
        response += result;
    } else if (path == "/obtener_municipios") {
        std::string departamento;
        iss >> departamento;
        std::string query = "SELECT * FROM municipio WHERE id_departamento = " + departamento;
        std::string result;
        if (!ejecutarConsulta(conn, query, result)) {
            write(client_socket, NOT_FOUND_RESPONSE.c_str(), NOT_FOUND_RESPONSE.size());
            close(client_socket);
            return;
        }
        response += result;
    } else if (path == "/buscar") {
        std::string provincia, departamento, municipio;
        iss >> provincia >> departamento >> municipio;
        std::string query = "SELECT * FROM localidad WHERE id_provincia = " + provincia;
        if (!departamento.empty()) {
            query += " AND id_departamento = " + departamento;
        }
        if (!municipio.empty()) {
            query += " AND id_municipio = " + municipio;
        }
        std::string result;
        if (!ejecutarConsulta(conn, query, result)) {
            write(client_socket, NOT_FOUND_RESPONSE.c_str(), NOT_FOUND_RESPONSE.size());
            close(client_socket);
            return;
        }
        response += result;
    } else {
        write(client_socket, NOT_FOUND_RESPONSE.c_str(), NOT_FOUND_RESPONSE.size());
        close(client_socket);
        return;
    }

    write(client_socket, response.c_str(), response.size());
    close(client_socket);
}

int main() {
    MYSQL *conn = mysql_init(NULL);
    if (conn == NULL) {
        std::cerr << "Error al inicializar la conexión a MySQL." << std::endl;
        return 1;
    }

    if (mysql_real_connect(conn, "localhost", "root@localhost", "", "diagnostico", 0, NULL, 0) == NULL) {
        std::cerr << "Error al conectarse a la base de datos MySQL." << std::endl;
        return 1;
    }

    int server_fd, new_socket;
    struct sockaddr_in address;
    int opt = 1;
    int addrlen = sizeof(address);

    if ((server_fd = socket(AF_INET, SOCK_STREAM, 0)) == 0) {
        std::cerr << "Error al crear el socket." << std::endl;
        return 1;
    }

    if (setsockopt(server_fd, SOL_SOCKET, SO_REUSEADDR | SO_REUSEPORT, &opt, sizeof(opt))) {
        std::cerr << "Error al configurar opciones del socket." << std::endl;
        return 1;
    }
    address.sin_family = AF_INET;
    address.sin_addr.s_addr = INADDR_ANY;
    address.sin_port = htons(PORT);

    if (bind(server_fd, (struct sockaddr *)&address, sizeof(address))<0) {
        std::cerr << "Error al vincular el socket al puerto." << std::endl;
        return 1;
    }

    if (listen(server_fd, 3) < 0) {
        std::cerr << "Error al escuchar las conexiones entrantes." << std::endl;
        return 1;
    }

    while (true) {
        if ((new_socket = accept(server_fd, (struct sockaddr *)&address, (socklen_t*)&addrlen))<0) {
            std::cerr << "Error al aceptar la conexión entrante." << std::endl;
            return 1;
        }

        handle_request(new_socket, conn);
    }

    mysql_close(conn);
    return 0;
}
