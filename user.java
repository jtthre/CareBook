import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/users")
public class UserController {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    @GetMapping("/search")
    public List<Map<String, Object>> searchUser(@RequestParam String username) {
        // ⚠️ CODE VULNÉRABLE : Injection SQL possible
        String query = "SELECT * FROM users WHERE username = '" + username + "'";
        return jdbcTemplate.queryForList(query);
    }
}
